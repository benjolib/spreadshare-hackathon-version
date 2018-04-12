<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;
use DS\Model\UserNotifications;

class ActivityController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function indexAction()
    {
        $userId = $this->serviceManager->getAuth()->getUserId();

        $userNotifications = new UserNotifications;
        $this->view->setVar('notifications', $userNotifications->findNotifications($userId));

        $this->view->setMainView('activity/index');
    }
}
