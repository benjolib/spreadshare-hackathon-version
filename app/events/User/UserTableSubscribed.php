<?php

namespace DS\Events\User;

use DS\Events\AbstractEvent;
use DS\Model\DataSource\TableLogType;
use DS\Model\DataSource\UserNotificationType;
use DS\Model\TableLog;
use DS\Model\Tables;
use DS\Model\TableStats;
use DS\Model\User;
use DS\Model\UserNotifications;

/**
 * Spreadshare
 *
 * Table events like views or contributions
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Events\Table
 */
class UserTableSubscribed extends AbstractEvent
{
    
    /**
     * Issued after a has been followed by another user
     *
     * @param int $userId
     * @param int $followedByUserId
     */
    public static function after(int $userId, int $tableId)
    {
        $user  = User::findFirstById($userId);
        $table = Tables::findFirstById($tableId);
        
        $userNotification = new UserNotifications;
        $userNotification
            ->setUserId($table->getOwnerUserId())
            ->setNotificationType(UserNotificationType::TableSubscribed)
            ->setSourceUserId($userId)
            ->setSourceTableId($tableId)
            ->setText(sprintf('Subscribed to %s', $table->getTitle()))
            ->setPlaceholders(
                json_encode(
                    [
                        $user->getName(),
                        $table->getTitle(),
                    ]
                )
            )
            ->create();
        
        $tableLog = new TableLog();
        $tableLog
            ->setUserId($userId)
            ->setTableId($tableId)
            ->setLogType(TableLogType::Subscribed)
            ->setText('Subscribed this Stream.')
            ->setPlaceholders(
                json_encode(
                    [
                        $user->getId(),
                        $user->getName(),
                    ]
                )
            )
            ->create();
        
        $tableStats = TableStats::findByFieldValue('tableId', $tableId);
        if (!$tableStats)
        {
            $tableStats = new TableStats;
        }
        $tableStats->setSubscriberCount($tableStats->getSubscriberCount() + 1)->save();
    }
    
}