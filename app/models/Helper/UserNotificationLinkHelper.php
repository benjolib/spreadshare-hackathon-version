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
                return '/profile/' . $notification['userHandle'];
                break;
            case UserNotificationType::TableUpvoted:
            case UserNotificationType::TableCreated:
                return '/stream/'.$notification['sourceTableId'];
            case UserNotificationType::TableSubscribed:
                return '/profile/' . $notification['userHandle'];           
            case UserNotificationType::TableDownvoted:
            case UserNotificationType::Changed:
            case UserNotificationType::ChangeRequestedConfirmed:
                return '/collaborations';
            case UserNotificationType::ChangeRequestedRejected:
                return '/table/' . $notification['sourceTableId'];
            case UserNotificationType::Commented:
                return '/stream/' . $notification['sourceTableId'] . '/#discussion';
                break;
            case UserNotificationType::ChangeRequested:
                return '/collaborations/#received';
                break;
        }
        
        return '/';
    }
}
