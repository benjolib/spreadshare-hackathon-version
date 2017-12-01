<?php

namespace DS\Events\Table;

use DS\Events\AbstractEvent;
use DS\Model\ChangeRequests;
use DS\Model\DataSource\ChangeRequestStatus;
use DS\Model\DataSource\UserNotificationType;
use DS\Model\TableRows;
use DS\Model\Tables;
use DS\Model\TableStats;
use DS\Model\User;
use DS\Model\UserNotifications;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Events\Table
 */
class TabelCellChangeReviewed extends AbstractEvent
{
    
    /**
     * Table cell change has been revied. Get the result from $changeRequest->getStatus()
     *
     * @param ChangeRequests $changeRequest
     * @param int            $tableId
     */
    public static function after(ChangeRequests $changeRequest, int $tableId)
    {
        $userNotification = new UserNotifications();
        
        $table = Tables::get($tableId);
        
        $userNotification
            ->setUserId($changeRequest->getUserId())
            ->setSourceTableId($tableId)
            ->setPlaceholders(
                json_encode(
                    [
                        User::get($changeRequest->getUserId())->getName(),
                        $table->getTitle(),
                    ]
                )
            )
            ->setSourceUserId($table->getOwnerUserId());
        
        // Rebuild rows cache if change was confirmed
        if ($changeRequest->getStatus() == ChangeRequestStatus::Confirmed)
        {
            $rows = new TableRows;
            $rows->rebuildRowCache($tableId);
            
            $userNotification
                ->setNotificationType(UserNotificationType::ChangeRequestedConfirmed)
                ->setText(sprintf('confirmed your change request for table %s', $table->getTitle()))
                ->create();
            
            // Increment contribution counter
            (new TableStats)->increment($tableId, 'contribution');
            
        }
        elseif ($changeRequest->getStatus() == ChangeRequestStatus::Rejected)
        {
            $userNotification
                ->setNotificationType(UserNotificationType::ChangeRequestedRejected)
                ->setText(sprintf('rejected your change request for table %s', $table->getTitle()))
                ->create();
        }
    }
    
}