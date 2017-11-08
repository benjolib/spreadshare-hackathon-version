<?php

namespace DS\Controller;

use DS\Application;
use DS\Component\Auth;
use DS\Component\ServiceManager;
use Phalcon\Exception;
use Phalcon\Logger;

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
class LogoutController
    extends BaseController
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
                $auth->removeSession();
                
                
                $this->response->redirect('/', true, 301);
                $this->view->disable();
                
                return;
            }
            
            header('Location: /');
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
    
}
