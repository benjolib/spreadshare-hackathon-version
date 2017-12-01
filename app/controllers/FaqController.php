<?php

namespace DS\Controller;

use DS\Application;
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
class FaqController
    extends BaseController
{
    /**
     * Spreadshare
     */
    public function indexAction($params = [])
    {
        try
        {
            $this->view->setMainView('pages/faq/company');
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }


    /**
     * product
     */
    public function productAction($params = [])
    {
        try
        {
            $this->view->setMainView('pages/faq/product');
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }

    /**
     * content
     */
    public function contentAction($params = [])
    {
        try
        {
            $this->view->setMainView('pages/faq/content');
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }



    /**
     * token
     */
    public function tokenAction($params = [])
    {
        try
        {
            $this->view->setMainView('pages/faq/token');
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }


}
