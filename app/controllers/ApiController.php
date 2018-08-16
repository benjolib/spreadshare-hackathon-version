<?php

namespace DS\Controller;

use DS\Application;
use DS\Component\ServiceManager;
use DS\Controller\Api\Meta\Error;
use DS\Controller\Api\Meta\RecordInterface;
use DS\Controller\Api\Response\Json;
use DS\Controller\Api\Response\Text;
use DS\Exceptions\InvalidParameterException;
use DS\Exceptions\UserValidationException;
use DS\Exceptions\SecurityException;
use DS\Model\DataSource\ErrorCodes;
use Phalcon\Di;
use Phalcon\DiInterface;
use Phalcon\Logger;
use Phalcon\Mvc\Controller as PhalconMvcController;

/**
 * Spreadshare
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 *
 * @property \Phalcon\Http\Request  request
 * @property \Phalcon\Http\Response response
 *
 * @method DiInterface getDi()
 */
class ApiController extends PhalconMvcController
{
    /**
     * @var string
     */
    private $actionHandlerClass = \DS\Controller\Api\ActionHandler::class;
    
    /**
     * Initialize controller and define index view
     */
    public function initialize()
    {
        if (!$this->request) {
            // ensure request is in place
            $this->request = $this->getDI()->get('request');
        }
    }
    
    /**
     * Log exceptions thrown within the api method
     *
     * @param \Exception $e
     * @param string     $method
     * @param string     $action
     * @param string     $responseType
     */
    protected function logException($e, $method = '', $action = '', $responseType = '')
    {
        try {
            // Log exception to sentry
            $ravenClient = ServiceManager::instance($this->getDi())->getRavenClient();
            if ($ravenClient) {
                $ravenClient->tags_context(['errorType' => get_class($e)]);
                $ravenClient->captureException(
                    $e,
                    null,
                    null,
                    [
                        'method' => $method,
                        'responseType' => $responseType,
                        'action' => $action,
                    ]
                );
            }
            
            // Log exception to system log
            Application::instance()->log(
                (method_exists($e, 'getErrorCode') ? $e->getErrorCode() . ':' : '') . $e->getMessage() . ' - ' .
                (method_exists($e, 'getMore') ? var_export($e->getMore(), true) : '') . ' - Body: ' . $this->request->getRawBody() . ' | ' . str_replace(
                    "\n",
                    "",
                    var_export($e->getTraceAsString(), true)
                ),
                Logger::ERROR
            );
        } catch (\Exception $e) {
            var_dump($e);
        }
    }

    /**
     * Camel case a minus-separated string
     *
     * @param $str
     * @return string
     */
    protected function camelCase($str): string
    {
        if (strpos($str, '-') > 0) {
            // We have '-' signs inside the string. Need to Camel Case it. Ex.: 'one-two-three'
            // 1. Replace each '-' with a space. Thus we'll have string of separate words. Ex.: 'one two three'
            // 2. Uppercase each word with ucwords(). Ex.: 'One Two Three'
            // 3. Cut out spaces - replce spaces with  ''. Ex.: 'OneTwoThree'
            return str_replace(' ', '', ucwords(str_replace('-', ' ', str)));
        } else {
            // No '-' inside the str - just make first char uppercased
            return ucfirst($str);
        }
    }

    /**
     * Camel case HTTP method of the current request
     *
     * @return string
     *  Get
     *  Post
     *  Delete
     *  ...
     */
    protected function camelCaseHTTPMethod(): string
    {
        // Define class name, based on request type, default is Get
        // GET
        // POST
        // PUT
        // PATCH
        // DELETE
        // OPTIONS
        // are translated 'as it is'

        // HEAD
        // CONNECT
        // TRACE
        // are defaulted as 'Get'

        if ($this->request->isGet()) {
            return 'Get';
        }

        if ($this->request->isPost()) {
            return 'Post';
        }

        if ($this->request->isPut()) {
            return 'Put';
        }

        if ($this->request->isPatch()) {
            return 'Patch';
        }

        if ($this->request->isDelete()) {
            return 'Delete';
        }

        if ($this->request->isOptions()) {
            return 'Options';
        }

        return 'Get';
    }

    /**
     * Default index request
     *
     * @return mixed
     */
    public function routeAction()
    {
        $di = $this->getDi();
        
        // Disable view processing since the api has it's own responses
        $this->view->disable();

        // Prepare some request variables
        $version = $this->dispatcher->getParam("version");
        $method  = $this->camelCase($this->dispatcher->getParam("method"));
        $action  = $this->dispatcher->getParam("subaction");
        $id      = $this->dispatcher->getParam("id");
        $auth    = ServiceManager::instance($this->getDI())->getAuth();

        // Construct class name of the action handler
        $className = __NAMESPACE__ . "\\Api\\v{$version}\\{$method}\\" . $this->camelCaseHTTPMethod();

        // Switch between response types, default is json
        $responseType = $this->request->get('type', 'string', 'json');
        $response = $responseType === 'string' ? new Text($di) : new Json($di);

        try {
            // Send CORS header to allow access from the requested domain
            // @todo change this to the only allowed domain(s) in production
            $response
                ->getResponse()
                ->setHeader('Access-Control-Allow-Origin', $this->request->getServer('HTTP_ORIGIN') ?: $this->request->getServer('HTTP_HOST'))
                ->setHeader('Access-Control-Allow-Credentials', 'true');

            // Check if api controller exists
            if (!class_exists($className) || !is_a($className, $this->actionHandlerClass, true)) {
                throw new InvalidParameterException('Invalid method: ' . $method);
            }

            // @var $controller \DS\Controller\Api\ActionHandler
            $controller = new $className();
            $controller->setDi($di);

            // Check whether the controller needs a login
            if ($controller->needsLogin() && !$auth->loggedIn()) {
                throw new SecurityException('Need login');
            }

            // Set id and action for current action
            $controller->setAction($action)->setId($id);

            // E-Tag handling
            // Calculate ETag on server-side and compare it with provided by client
            $serverETag = $controller->getEtag();

            if ($serverETag) {
                $response->getResponse()
                    ->setEtag($serverETag)
                    ->setHeader('Pragma', 'cache');

                $clientETag = $this->request->getHeader('if-none-match');
                if ($clientETag && $clientETag === $serverETag) {
                    // Client presented the same ETag - not need to deliver content
                    $response->getResponse()->setHeader('Cache-Control', 'must-revalidate');
                    $response->getResponse()->setNotModified();
                    $response->getResponse()->send();
                    die;
                }

                // Client ETag is absent or not valid - specify caching
                $response->getResponse()->setCache(60 * 24);
            }

            // Call process method to process the request or initialize the controller
            $actionResult = $controller->process();

            // Then additionally call action method, if there is one
            if ($action && method_exists($controller, $action)) {
                $actionResult = $controller->$action();
            }

            if ($actionResult instanceof RecordInterface) {
                // Attach action result to response
                $response->set($actionResult);
            } elseif ($actionResult instanceof Error) {
                // Handle possible errors
                $response->setError($actionResult);
            } else {
                $response->set(null, false);
            }

        } catch (\Error $e) {
            $response->setError(new Error($e->getMessage() . ' ('.str_replace(ROOT_PATH, '', $e->getFile()).':'.$e->getLine().')', 'There was an internal error. Our team is informed. Please try again in a few minutes. Sorry for this!', ErrorCodes::InvalidParameter));
            $this->logException($e, $method, $action, $responseType);
        } catch (InvalidParameterException $e) {
            $response->setError(new Error($e->getMessage(), $e->getMessage(), ErrorCodes::InvalidParameter));
            $this->logException($e, $method, $action, $responseType);
        }
        /*catch (ApiException $e)
        {
            $error = new Error('Api Error', $e->getMessage(), ErrorCodes::ApiError);
            $error
                ->setMore($e->getMore())
                ->setDevMessage($e->getDevMessage())
                ->setErrorCode($e->getErrorCode());
            
            $response->setError($error);
            
            $this->logException($e, $method, $action, $responseType);
        }*/
        catch (SecurityException $e) {
            $response->setError(
                new Error('Session Error', 'It seems like your session timed out. Please relogin.', ErrorCodes::SessionExpired)
            );
        } catch (UserValidationException $e) {
            $error = new Error('Validation Error', $e->getMessage(), ErrorCodes::UserValidation);
            $error
                ->setMore($e->getFixMessage())
                ->setError($e->getMessage())
                ->setDevMessage($e->getField() . ' has value ' . $e->getValue())
                ->setErrorCode($e->getCode());
            
            $response->setError($error);
        } catch (\Exception $e) {
            $response->setError(new Error('Api Error', $e->getMessage(), ErrorCodes::GeneralException, $e->getTraceAsString()));
            $this->logException($e, $method, $action, $responseType);
        }

        if (is_null($response->getResponse()->getContent()) && !$response->getError()) {
            // In case no response content returned treat it as an error
            $response->setError(new Error('Api Error.', 'There was an internal error contacting the Api.', 'No response set by the api method.'));
        }

        $response->send();

        return $response;
    }
}
