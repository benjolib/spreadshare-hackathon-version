<?php

namespace DS\Events\User;

use DS\Events\AbstractEvent;
use DS\Model\DataSource\UserNotificationType;
use DS\Model\User;
use DS\Model\UserNotifications;

/**
 * Spreadshare
 *
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Events\Table
 */
class UserFollowed extends AbstractEvent
{
    
    /**
     * Issued after a has been followed by another user
     *
     * @param int $userId
     * @param int $followedByUserId
     */
    public static function after(int $userId, int $followedByUserId)
    {
        $user = User::findFirstById($followedByUserId);
        
        $userNotification = new UserNotifications;
        $userNotification
            ->setUserId($user->getId())
            ->setSourceUserId($userId)
            ->setNotificationType(UserNotificationType::Follow)
            ->setText('started following you')
            ->setPlaceholders(
                json_encode(
                    [
                        $user->getName(),
                    ]
                )
            )
            ->create();
    }
    
}