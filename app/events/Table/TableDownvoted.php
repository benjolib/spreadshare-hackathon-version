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
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Events\Table
 */
class TableDownvoted extends AbstractEvent
{
    
    /**
     * Issued after a table has been upvoted
     *
     * @param int $userId
     * @param int $tableId
     */
    public static function after(int $userId, int $tableId)
    {
        $user  = User::findFirstById($userId);
        $table = Tables::findFirstById($tableId);
        
        $userNotification = new UserNotifications();
        $userNotification
            ->setUserId($table->getOwnerUserId())
            ->setNotificationType(UserNotificationType::TableUpvoted)
            ->setText(sprintf('%s revoked his vote for your table %s', $user->getName(), $table->getTitle()))
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
    }
    
}