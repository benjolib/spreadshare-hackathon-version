<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;

class CreateListController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function indexAction()
    {
        $this->view->setMainView('create-list/index');

        $user = $this->serviceManager->getAuth()->getUser();

        $this->view->setVar('editing', true);
    }
}
