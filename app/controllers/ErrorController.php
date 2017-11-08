<?php
namespace DS\Controller;

use \Phalcon\Mvc\Controller as PhalconMvcController;

/**
 *
 * Spreadshare
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version $Version$
 * @package DS\Controller
 */
class ErrorController extends PhalconMvcController
{
    /**
     * Show 404 error message
     */
    public function showAction()
    {
        $this->response->setStatusCode(404, 'Not Found');
        $this->view->setMainView('404/404');
    }
}
