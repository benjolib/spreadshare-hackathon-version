<?php

namespace DS\Controller;

use DS\Application;
use DS\Model\User;
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
class SignupController
    extends BaseController
{
    /**
     * Signup form
     */
    public function indexAction($params = [])
    {
        try
        {
            if ($this->request->isPost())
            {
                // Create new user
                $userModel = (new User())
                    ->addUserFromSignup(
                        $this->request->getPost('name'),
                        $this->request->getPost('handle'),
                        $this->request->getPost('email'),
                        $this->request->getPost('password')
                    );
                
                // User is now directly logged in:
                $this->serviceManager->getAuth()->storeSession($userModel);
                
                // Redirect to topics page
                header('Location: /signup/topics');
                //$this->response->redirect('/signup/topics', false);
                
                // Disable further rendering
                $this->view->disable();
            }
        }
        catch (Exception $e)
        {
            $this->view->setVar('signupSuccessfull', false);
            $this->view->setVar('errorMessage', $e->getMessage());
            $this->view->setVar('post', $this->request->getPost());
        }
        
        $this->view->setMainView('auth/signup');
    }
    
    /**
     * Topics
     */
    public function topicsAction($params = [])
    {
        try
        {
            $this->view->setMainView('auth/onboarding/topics');
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
    
    /**
     * Tables
     */
    public function tablesAction($params = [])
    {
        try
        {
            $this->view->setMainView('auth/onboarding/tables');
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
    
    /**
     * Tables
     */
    public function followAction($params = [])
    {
        try
        {
            $this->view->setMainView('auth/onboarding/follow');
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
    
    /**
     * Tables
     */
    public function locationAction($params = [])
    {
        try
        {
            $this->view->setMainView('auth/onboarding/location');
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
}
