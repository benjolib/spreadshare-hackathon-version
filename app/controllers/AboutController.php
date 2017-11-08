<?php
namespace DS\Controller;

use DS\Application;
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
class AboutController
    extends PhalconMvcController
{
    /**
     * About
     */
    public function indexAction($params = [])
    {
        try
        {
            $this->view->setMainView('pages/about');
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }

}
