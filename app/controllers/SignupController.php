<?php

namespace DS\Controller;

use DS\Application;
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
            $this->view->setMainView('auth/signup');
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
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
