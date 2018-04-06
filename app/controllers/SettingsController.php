<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;

class SettingsController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function indexAction()
    {
        $this->view->setMainView('settings/index');
    }
}
