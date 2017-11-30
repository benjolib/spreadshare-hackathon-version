<?php

namespace DS\Controller\Table;

use DS\Controller\BaseController;
use DS\Exceptions\SecurityException;
use DS\Interfaces\TableSubcontrollerInterface;
use DS\Model\ChangeRequests;
use DS\Model\DataSource\ChangeRequestStatus;
use DS\Model\Helper\ChangeRequestsFilter;
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
     * @param int    $userId
     *
     * @return $this
     */
    public function handle(Tables $table, int $userId, string $param)
    {
        try
        {
            if ($table->getOwnerUserId() != $userId)
            {
                throw new SecurityException('You are not allowed to view this section.');
            }
            
            $changeRequestsModel = new ChangeRequests;
            
            $status = ChangeRequestStatus::All;
            $filter = new ChangeRequestsFilter();
            switch ($param)
            {
                case ChangeRequestsFilter::ONLY_NEW:
                    $status = ChangeRequestStatus::AwaitingApproval;
                    break;
                case ChangeRequestsFilter::ONLY_EDITS:
                    $filter->setShowOnly($param);
                    break;
                case ChangeRequestsFilter::ONLY_DELETES:
                    $filter->setShowOnly($param);
                    break;
                case ChangeRequestsFilter::ONLY_CONFIRMED:
                    $status = ChangeRequestStatus::Confirmed;
                    break;
                case ChangeRequestsFilter::ONLY_REJECTED:
                    $status = ChangeRequestStatus::Rejected;
                    break;
                default:
                    $filter->setShowOnly(ChangeRequestsFilter::ONLY_ALL);
                    break;
            }
            $changeRequests = $changeRequestsModel->findChangeRequests($table->getId(), $filter, $status);
            
            $this->view->setVar('requests', $changeRequests);
            $this->view->setVar('page', $param);
            
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