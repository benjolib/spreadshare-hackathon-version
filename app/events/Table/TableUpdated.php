<?php

namespace DS\Events\Table;

use DS\Events\AbstractEvent;
use DS\Model\DataSource\TableLogType;
use DS\Model\DataSource\UserNotificationType;
use DS\Model\TableLog;
use DS\Model\Tables;
use DS\Model\UserNotifications;
use DS\Modules\Bernard;

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
class TableUpdated extends AbstractEvent
{
    
    /**
     * Issued after a table has been modified
     *
     * @param int    $userId
     * @param Tables $table
     */
    public static function after(int $userId, Tables $table)
    {
        if ($table->getId())
        {
            // DataSource
            $datasource = [
                'isUpdated' => true,
                'tableId' => $table->getId(),
                'tableTitle' => $table->getTitle(),
                'tableTagline' => $table->getTagline(),
            ];
            
            // Send Table Creation Event To ES Queue
//            Bernard::produce('touchTable', $datasource);
        }
        
        // Show notification for this change if this change was not initiated by the owner
        if ($table->getOwnerUserId() != $userId)
        {
            $userNotification = new UserNotifications();
            $userNotification
                ->setUserId($table->getOwnerUserId())
                ->setSourceUserId($userId)
                ->setSourceTableId($table->getId())
                ->setNotificationType(UserNotificationType::Changed)
                ->setText(sprintf('updated your table %s', $table->getTitle()))
                ->setPlaceholders(
                    json_encode(
                        [
                            $table->getTitle(),
                        ]
                    )
                )
                ->create();
        }
        
        $tableLog = new TableLog();
        $tableLog
            ->setUserId($userId)
            ->setTableId($table->getId())
            ->setLogType(TableLogType::Updated)
            ->setText('updated table settings.')
            ->setPlaceholders(
                json_encode(
                    [
                        $table->getTitle(),
                    ]
                )
            )
            ->create();
    }
    
}
