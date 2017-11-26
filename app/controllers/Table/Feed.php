<?php

namespace DS\Controller\Table;

use DS\Controller\BaseController;
use DS\Interfaces\TableSubcontrollerInterface;
use DS\Model\TableLog;
use DS\Model\Tables;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller\User
 */
class Feed
    extends BaseController
    implements TableSubcontrollerInterface
{
    
    /**
     * Handle Subcontroller
     *
     * @param Tables $table
     *
     * @return $this
     */
    public function handle(Tables $table, int $userId, string $param)
    {
        try
        {
            $tableLog = new TableLog();
            $this->view->setVar('logs', $tableLog->getLogs($table->getId()));
            
            $this->view->setMainView('table/detail/feed');
            $this->view->setVar('selectedPage', 'feed');
        }
        catch (\Exception $e)
        {
            throw $e;
        }
        
        return $this;
    }
}