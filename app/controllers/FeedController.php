<?php

namespace DS\Controller;

use DS\Application;
use DS\Exceptions\SecurityException;
use DS\Model\DataSource\UserNotificationType;
use DS\Model\UserNotifications;
use Phalcon\Exception;
use Phalcon\Logger;

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
            $this->view->setVar('notifications', $userNotifications->findNotifications($userId, $typeId));
            
            $this->view->setMainView('feed/feed');
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
}
