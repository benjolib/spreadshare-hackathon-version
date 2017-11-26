<?php

namespace DS\Controller\Table;

use DS\Controller\BaseController;
use DS\Events\Table\TableViewed;
use DS\Interfaces\TableSubcontrollerInterface;
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
class Table
    extends BaseController
    implements TableSubcontrollerInterface
{
    
    /**
     * Handle Subcontroller
     *
     * @param Tables $table
     * @param int $userId
     *
     * @return $this
     */
    public function handle(Tables $table, int $userId, string $param)
    {
        try
        {
            TableViewed::after($this->serviceManager->getAuth()->getUserId(), (int) $table->getId());
            $this->view->setMainView('table/detail/table');
            
            $this->view->setVar('selectedPage', 'table');
        }
        catch (\Exception $e)
        {
            throw $e;
        }
        
        return $this;
    }
}