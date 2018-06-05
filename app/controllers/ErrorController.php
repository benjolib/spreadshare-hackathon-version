<?php

namespace DS\Controller;

use Phalcon\Mvc\Controller as PhalconMvcController;

/**
 *
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
class ErrorController extends PhalconMvcController
{
    /**
     * Show 404 error message
     */
    public function notFoundAction()
    {
        $this->response->setStatusCode(404, 'Not Found');
        $this->view->setMainView('404/404');
    }
    
    /**
     * Show 500 error message
     */
    public function errorAction(\Exception $exception)
    {
        $this->response->setStatusCode(500, 'Error');
        
        $this->view->setVar('error', $exception->getMessage().'<br>'.nl2br($exception->getTraceAsString()));
        $this->view->setMainView('404/500');
        
    }
}
