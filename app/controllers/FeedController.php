<?php

namespace DS\Controller;

use DS\Exceptions\SecurityException;
use DS\Model\DataSource\UserNotificationType;
use DS\Model\Helper\UserNotificationLinkHelper;
use DS\Model\UserNotifications;
use Phalcon\Exception;

/**
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
class FeedController
    extends BaseController
{
    /**
     * Spreadshare
     */
    public function indexAction($type = '')
    {
        try
        {
            $this->view->setMainView('feed/feed');
            
            $userId = $this->serviceManager->getAuth()->getUserId();
            
            if (!$userId)
            {
                throw new SecurityException('You are not allowed to view this page. Please create an account first!');
            }
            
            $typeId = null;
            if (isset(UserNotificationType::$map[$type]))
            {
                $typeId = UserNotificationType::$map[$type];
            }
            
            $userNotifications = new UserNotifications;
            $this->view->setVar('linkHelper', new UserNotificationLinkHelper());
            $this->view->setVar('notifications', $userNotifications->findNotifications($userId, $typeId));
            $this->view->setVar('type', $type);
            
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }
}
