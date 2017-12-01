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
class TokenController
    extends BaseController
{
    /**
     * motivation
     */
    public function indexAction($params = [])
    {
        try
        {
            $this->view->setMainView('pages/token/motivation');
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }


    /**
     * howitworks
     */
    public function howitworksAction($params = [])
    {
        try
        {
            $this->view->setMainView('pages/token/howitworks');
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }

}
