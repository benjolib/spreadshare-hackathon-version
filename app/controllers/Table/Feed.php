<?php

namespace DS\Controller\Table;

use DS\Controller\BaseController;
use DS\Interfaces\TableSubcontrollerInterface;
use DS\Model\DataSource\TableLogType;
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
    public function handle(Tables $table, int $userId, string $tab, string $param)
    {
        try
        {
            
            $typeIds = [];
            if (isset(TableLogType::$map[$param]))
            {
                $typeIds = TableLogType::$map[$param];
            }
            
            $tableLog = new TableLog();
            $this->view->setVar('logs', $tableLog->getLogs($table->getId(), 0, $typeIds));
            $this->view->setMainView('table/detail/feed');
            $this->view->setVar('selectedTab', $param);
            $this->view->setVar('selectedPage', 'feed');
        }
        catch (\Exception $e)
        {
            throw $e;
        }
        
        return $this;
    }
}