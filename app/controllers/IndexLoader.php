<?php
namespace DS\Controller;

use Phalcon\Mvc\Controller;

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
abstract class IndexLoader
    extends BaseController
{
    /**
     * Initialize controller and define index view
     */
    public function initialize()
    {
        if (!$this->request) $this->request = $this->getDI()->get('request');

        // Setting main view for all sub-requests
        //$this->view->setMainView('internal/index');
    }
}
