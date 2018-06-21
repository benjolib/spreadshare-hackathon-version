<?php

namespace DS\Controller\Api\v1\Notifications;

use DS\Component\UserComponent\StringFormat;
use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Record;
use DS\Controller\Api\MethodInterface;
use DS\Model\Helper\UserNotificationLinkHelper;
use DS\Model\UserNotifications;
use DS\Model\UserStats;

/**
 *
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
class Get extends ActionHandler implements MethodInterface
{
    /**
     * @return bool
     */
    public function needsLogin()
    {
        return true;
    }

    /**
     * Process Get Method
     *
     * @return mixed
     */
    public function process()
    {
        if ($this->request->isAjax()) {
            $userId = $this->getServiceManager()->getAuth()->getUserId();

            if ($userId > 0) {
                $page               = $this->request->get('p', null, 0);
                $notifications      = new UserNotifications;
                $notificationsArray = $notifications->findNotifications($userId, null, $page, 10);

                if (count($notificationsArray)) {
                    UserStats::decrement($userId, 'unreadNotifications', count($notificationsArray));

                    $output = '';
                    foreach ($notificationsArray as $notification) {
                        try {
                            $output .= '
 <div class="notification-dropdown__notification u-flex u-flexAlignItemsCenter">
  <a href="/user/' . $notification['userHandle'] . '">
  <img class="notification-dropdown__notification__image" src="' . $notification['userImage'] . '" />
  </a>

<div style="width:100%;">
<div class="u-flex u-flexJustifyBetween">
  <a href="'. UserNotificationLinkHelper::getLink($notification) .'">
      <span class="notification-dropdown__notification__name">' . $notification['userName'] . '</span>
  </a>
  <div class="notification-dropdown__notification__date"><img src="/assets/images/comment-clock.svg" />' . StringFormat::factory()->prettyDateTimestamp($notification['createdAt']) . '</div>
  </div>
        <p class="notification-dropdown__notification__text">
        ' . $notification['text'] . '</p>
        </div>
      </div>
    ';
                        } catch (\Exception $e) {
                        }
                    }

                    $output .= '<div class="notification-dropdown__notification__see-all">
    <a href="/feed">See all</a>
</div>';
                } else {
                    $output = '<div class="center">
  <p>You have no notifications</p>
</div>';
                }

                $this->response->setContent($output)->send();
                die;
            }
        }

        return new Record(true);
    }
}
