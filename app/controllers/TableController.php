<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;

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
    implements LoginAwareController
{
    /**
     * @return bool
     */
    public function needsLogin()
    {
        return true;
    }
    
    /**
     * Table
     */
    public function indexAction($params = [])
    {
        $this->view->setMainView('table/table');
    }
}
