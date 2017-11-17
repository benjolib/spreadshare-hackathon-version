<?php

namespace DS\Events\Table;

use DS\Events\AbstractEvent;
use DS\Model\DataSource\UserNotificationType;
use DS\Model\Tables;
use DS\Model\User;
use DS\Model\UserNotifications;

/**
 * Spreadshare
 *
 * Table events like views or contributions
 * Used to distribute all actions that are associated with a table
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
            ->setUserId($userId)
            ->setNotificationType(UserNotificationType::Follow)
            ->setText(sprintf('%s started to subscribe your table %s', $user->getName()))
            ->setPlaceholders(
                json_encode(
                    [
                        $user->getName(),
                        $table->getTitle(),
                    ]
                )
            )
            ->create();
    }
    
}