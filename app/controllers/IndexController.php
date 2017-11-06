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
class IndexController
    extends BaseController
{
    /**
     * Home
     */
    public function indexAction($params = [])
    {
        try
        {
            $this->view->setMainView('frontpage');
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
    
}
