<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;

class CollaborationController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function indexAction()
    {
        $this->view->setMainView('collaborations/index');

        $user = $this->serviceManager->getAuth()->getUser();

        $this->view->setVar('collaborations', $user->getSubmissions());
    }
}
