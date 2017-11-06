<?php
namespace DS\Controller;

use DS\Application;
use DS\Component\Auth;
use DS\Component\ServiceManager;
use DS\Constants\Services;
use Phalcon\Exception;
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
 */
class AuthController
    extends PhalconMvcController
{
    /**
     * Home
     */
    public function indexAction($params = [])
    {
        try
        {
            /**
             * @var $auth Auth
             */
            $auth = ServiceManager::instance($this->di)->getAuth();

            // Relocate to feed view if user is logged in
            if ($auth->loggedIn())
            {
                // Calling redirect only sets the 302 response status.
                $this->response->redirect('/');
                
                return;
            }
            else
            {
                $this->view->setMainView('auth/register');
            }
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }

}
