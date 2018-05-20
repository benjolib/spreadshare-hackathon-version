<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;
use DS\Model\TableSubscription;

class SubscriptionsController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function indexAction()
    {
        $userId = $this->serviceManager->getAuth()->getUserId();
        $subscriptions = TableSubscription::findUserSubscriptions($userId);
        $this->view->setVar('subscriptions', $subscriptions);
        $this->view->setMainView('subscriptions/index');
    }
}
