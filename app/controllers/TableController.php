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
     * Home
     */
    public function indexAction($params = [])
    {
        $this->view->setMainView('table/table');
    }
    
}
