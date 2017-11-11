<?php

namespace DS\Controller;

use DS\Api\Login;
use DS\Application;
use DS\Component\Auth;
use DS\Component\ServiceManager;
use DS\Model\DataSource\UserStatus;
use DS\Model\User;
use Hybridauth\Adapter\AdapterInterface;
use Hybridauth\Exception\AuthorizationDeniedException;
use Hybridauth\Hybridauth;
use Phalcon\Exception;
use Phalcon\Logger;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
class LoginController
    extends BaseController
{
    /**
     * Home
     */
    public function indexAction($params = [])
    {
        try
        {
            // Login request with username and password
            if ($this->request->isPost() && $this->request->getPost('username') && $this->request->getPost('password'))
            {
                // Login...
                $login = new Login();
                if ($login->login($this->request->getPost('username'), $this->request->getPost('password')))
                {
                    header('Location: /');
                }
            }
            
            // Email confirmation request
            if ($this->request->get('token'))
            {
                $user = (new User())->findByFieldValue('emailConfirmationToken', $this->request->get('token'));
                
                if ($user)
                {
                    $user->setStatus(UserStatus::Confirmed)->setConfirmed(1)->save();
                }
            }
            
            // Login request from Twitter
            if ($this->request->get('oauth_token'))
            {
                return $this->loginWithTwitterAction();
            }
            
            // Login request from Facebook
            if ($this->request->get('code'))
            {
                return $this->loginWithFacebookAction();
            }
            
            /**
             * @var $auth Auth
             */
            $auth = ServiceManager::instance($this->di)->getAuth();
            
            // Relocate to feed view if user is logged in
            if ($auth->loggedIn())
            {
                // Calling redirect only sets the 302 response status.
                $this->response->redirect('/', true, 301);
                
                // Better disable the view to prevent the unnecessary rendering as well.
                $this->view->disable();
            }
        }
        catch (Exception $e)
        {
            $this->view->setVar('errorMessage', $e->getMessage());
        }
        
        $this->view->setMainView('auth/login');
        
        return null;
    }
    
    /**
     * Forgot password
     */
    public function forgotAction()
    {
        $this->view->setMainView('auth/forgot');
    }
    
    /**
     * Login with Twitter account
     */
    public function loginWithTwitterAction()
    {
        return $this->loginWith('Twitter');
    }
    
    /**
     * Login with Facebook account
     */
    public function loginWithFacebookAction()
    {
        return $this->loginWith('Facebook');
    }
    
    /**
     * @param $provider
     *
     * @return null
     */
    private function loginWith($provider)
    {
        try
        {
            $this->view->disable();
            
            //Feed configuration array to Hybridauth
            $hybridauth = new Hybridauth($this->di->get('config')->get('hybridauth')->toArray());
            
            //Attempt to authenticate users with a provider by name
            $adapter = $hybridauth->authenticate($provider);
            
            //Returns a boolean of whether the user is connected with Facebook
            $isConnected = $adapter->isConnected();
            
            if ($isConnected)
            {
                $this->loginSucceeded($adapter, $provider);
            }
            
            //Disconnect the adapter
            $adapter->disconnect();
        }
        catch (AuthorizationDeniedException $e)
        {
            $this->response->redirect('/');
        }
        catch (\Exception $e)
        {
            $this->response->redirect('/');
            //var_dump($e);
            //die;
        }
        
        return null;
    }
    
    /**
     * @param AdapterInterface $adapter
     * @param                  $provider
     */
    private function loginSucceeded(AdapterInterface $adapter, $provider)
    {
        //Retrieve the user's profile
        $userProfile = $adapter->getUserProfile();
        
        $user = User::addUserFromAuthService(
            trim($userProfile->firstName . ' ' . $userProfile->lastName),
            $this->cleanString(strtolower($userProfile->displayName), '-'),
            $userProfile->emailVerified,
            '',
            $userProfile->description,
            $userProfile->identifier,
            $userProfile->photoURL,
            $userProfile->city ? $userProfile->city : $userProfile->region,
            $provider
        );
        
        $this->serviceManager->getAuth()->storeSession($user);
        
        header('Location: /');
        $this->response->redirect('/', false);
        $this->view->disable();
    }
    
    /**
     * @param $string
     * @param $delimiter
     *
     * @return mixed|string
     */
    protected function cleanString($string, $delimiter)
    {
        // replace non letter or non digits by -
        $string = preg_replace('#[^\pL\d]+#u', '-', $string);
        
        // Trim trailing -
        $string = trim($string, '-');
        
        $clean = preg_replace('~[^-\w]+~', '', $string);
        $clean = strtolower($clean);
        $clean = preg_replace('#[\/_|+ -]+#', $delimiter, $clean);
        $clean = trim($clean, $delimiter);
        
        return $clean;
    }
}
