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
        $this->view->setVar('collabsActive', true);

        $this->view->setMainView('collaborations/index');

        $user = $this->serviceManager->getAuth()->getUser();

        $this->view->setVar('collaborations', $user->getCollaborations());
        $this->view->setVar('submissions', $user->getSubmissions());
    }
}
