<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;

class SubscriptionsController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function indexAction()
    {
        $this->view->setMainView('subscriptions/index');

        $user = $this->serviceManager->getAuth()->getUser();
    }
}
