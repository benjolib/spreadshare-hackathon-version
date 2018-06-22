<?php

namespace DS\Events\User;

use DS\Component\Mail\Events\NewFollowerMail;
use DS\Events\AbstractEvent;
use DS\Model\DataSource\UserNotificationType;
use DS\Model\User;
use DS\Model\UserNotifications;
use DS\Model\UserStats;

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
            ->setUserId($userId)
            ->setSourceUserId($followedByUserId)
            ->setNotificationType(UserNotificationType::Follow)
            ->setText('Started following you')
            ->setPlaceholders(
                json_encode(
                    [
                        $user->getName(),
                    ]
                )
            )
            ->create();
        
        NewFollowerMail::factory(self::getDI())
                       ->prepare(User::get($userId), User::get($followedByUserId))
                       ->send();
        
        UserStats::increment($userId, 'follower');
    }
    
}