<?php

namespace DS\Controller\Api\v1\Notifications;

use DS\Component\UserComponent\StringFormat;
use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Record;
use DS\Controller\Api\MethodInterface;
use DS\Model\UserNotifications;

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
        if ($this->request->isAjax())
        {
            $userId = $this->getServiceManager()->getAuth()->getUserId();
            
            if ($userId > 0)
            {
                $page               = $this->request->get('p', null, 0);
                $notifications      = new UserNotifications;
                $notificationsArray = $notifications->findNotifications($userId, null, $page, 10);
                
                if (count($notificationsArray))
                {
                    $output = '';
                    foreach ($notificationsArray as $notification)
                    {
                        try
                        {
                            $output .= '<div class="tableFeed__item">
<div class="tableFeed__item__avatar">
  <a href="/user/' . $notification['userHandle'] . '">
    <img src="' . $notification['userImage'] . '" />
  </a>
</div>
<div class="tableFeed__item__info">
  <div class="tableFeed__item__info__text">
      <span class="tableFeed__item__info__text__author">
        ' . $notification['userName'] . '
      </span>
    <span class="tableFeed__item__info__text__message">
        ' . $notification['text'] . '
      </span>
  </div>
  <div class="tableFeed__item__info__time">
    <span>' . StringFormat::factory()->prettyDateTimestamp($notification['createdAt']) . '</span>
  </div>
</div>
</div>';
                        }
                        catch (\Exception $e)
                        {
                        
                        }
                    }
                    
                    $output .= '<div class="tableFeed__item" style="margin-left:42%;">
    <a href="/feed">See all</a>
</div>';
                }
                else
                {
                    $output = '<div class="center">
  <p>There are no notifications available for you 😢</p>
</div>';
                }
                
                $this->response->setContent($output)->send();
                die;
            }
        }
        
        return new Record(true);
    }
    
}
