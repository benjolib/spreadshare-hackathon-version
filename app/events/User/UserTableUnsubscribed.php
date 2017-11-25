<?php

namespace DS\Events\User;

use DS\Events\AbstractEvent;
use DS\Model\DataSource\UserNotificationType;
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
class UserTableUnsubscribed extends AbstractEvent
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
            ->setNotificationType(UserNotificationType::Follow)
            ->setText(sprintf('%s unsubscribed your table %s', $user->getName(), $table->getTitle()))
            ->setPlaceholders(
                json_encode(
                    [
                        $user->getId(),
                        $user->getName(),
                        $table->getId(),
                        $table->getTitle(),
                    ]
                )
            )
            ->create();
        
        $tableStats = TableStats::findByFieldValue('tableId', $tableId);
        $tableStats->setSubscriberCount($tableStats->getSubscriberCount() - 1);
    }
    
}