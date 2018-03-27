<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;

class SubmissionController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function indexAction()
    {
        $this->view->setMainView('user/tables/submissions');

        $user = $this->serviceManager->getAuth()->getUser();
        $this->view->setVar('submissions', $user->getSubmissions());
    }
}
