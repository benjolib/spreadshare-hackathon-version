<?php

namespace DS\Events\User;

use DS\Application;
use DS\Component\Mailer\dto\UserMetaEmailDto;
use DS\Component\ServiceManager;
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
        $user = User::findFirstById($userId);
        $followedByUser = User::findFirstById($followedByUserId);

        $userNotification = new UserNotifications;
        $userNotification
            ->setUserId($userId)
            ->setSourceUserId($followedByUserId)
            ->setNotificationType(UserNotificationType::Follow)
            ->setText('Started following you')
            ->setPlaceholders(
                json_encode(
                    [
                        $followedByUser->getName(),
                    ]
                )
            )
            ->create();

        UserStats::increment($userId, 'follower');

        self::sendNewFollowerEmail($user, $followedByUser);

    }

    private static function sendNewFollowerEmail(User $user, User $followedByUser)
    {
        $domain = ServiceManager::instance(self::getDi())->getConfig()['domain'];
        $baseUri = "https://$domain";

        $followedByMeta = new UserMetaEmailDto($baseUri);
        $followedByMeta->withHandle($followedByUser->getHandle())
            ->setName($followedByUser->getName())
            ->setImageLink($followedByUser->getImage())
            ->setTagLine($followedByUser->getTagline());

        ServiceManager::instance(self::getDI())
            ->getMailService()
            ->sendNewFollowerEmail($user->getEmail(), $followedByMeta);
    }

}