<?php

namespace DS\Controller\Table;

use DS\Controller\BaseController;
use DS\Events\Table\TableViewed;
use DS\Interfaces\TableSubcontrollerInterface;
use DS\Model\ChangeRequests;
use DS\Model\Events\ChangeRequestsEvents;
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
class Changelog
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
            $changeRequestsModel = new ChangeRequests;
            $changeRequests = $changeRequestsModel->findChangeRequests($table->getId());
            
            $this->view->setVar('requests', $changeRequests);

            $this->view->setMainView('table/detail/changelog');
            $this->view->setVar('selectedPage', 'changelog');
        }
        catch (\Exception $e)
        {
            throw $e;
        }
        
        return $this;
    }
}