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
        if ($this->request->isPost()) {
            $this->view->setVar('post', $this->request->getPost());
        }
        
        
        $this->view->setMainView('create-list/index');

        $user = $this->serviceManager->getAuth()->getUser();

        $this->view->setVar('editing', true);
    }
}
