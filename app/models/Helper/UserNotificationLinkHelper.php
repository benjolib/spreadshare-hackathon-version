<?php

namespace DS\Model\Helper;

use DS\Model\DataSource\UserNotificationType;
use DS\Model\UserNotifications;

/**
 * Spreadshare
 *
 * Table Filter Model
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 */
class UserNotificationLinkHelper
{
    /**
     * @param UserNotifications $notification
     *
     * @return string
     */
    public static function getLink(array $notification): string
    {
        // $placeholders = json_decode($notification['placeholders'], true);
        
        switch ($notification['notificationType'])
        {
            case UserNotificationType::Follow:
                return '/user/' . $notification['userHandle'];
                break;
            case UserNotificationType::TableUpvoted:
            case UserNotificationType::TableSubscribed:
            case UserNotificationType::TableDownvoted:
            case UserNotificationType::Changed:
            case UserNotificationType::ChangeRequestedConfirmed:
            case UserNotificationType::ChangeRequestedRejected:
                return '/table/' . $notification['sourceTableId'];
            case UserNotificationType::Commented:
                return '/table/' . $notification['sourceTableId'] . '/about';
                break;
            case UserNotificationType::ChangeRequested:
                return '/table/' . $notification['sourceTableId'] . '/changelog/new';
                break;
        }
        
        return '/feed';
    }
}
