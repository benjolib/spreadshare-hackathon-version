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
class UserController
    extends BaseController
{
    /**
     * Home
     */
    public function indexAction($params = [])
    {
    
    }
    
    /**
     * Hunt
     */
    public function profileAction($handle)
    {
        try
        {
            $user = User::findByFieldValue('handle', $handle);
            
            if (!$user)
            {
                $this->response->redirect('/');
            }
            
            $this->view->setVar('profile', $user);
            $this->view->setMainView('user/profile');
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
    
}
