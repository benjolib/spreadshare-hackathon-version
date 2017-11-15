<?php

namespace DS\Controller;

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
class TableController
    extends BaseController
{
    /**
     * Table
     */
    public function indexAction($params = [])
    {
        $this->view->setMainView('table/table');
    }
    
    /**
     * Add table
     */
    public function addAction($params = [])
    {
        $this->view->setMainView('table/add');
    }
    
}
