<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;

class TempSignInController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return false;
    }

    public function indexAction()
    {
        $this->view->setVar('hideHeader', true);
        $this->view->setMainView('sign-in/index');
    }
}
