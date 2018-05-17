<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;

class HistoryController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function indexAction()
    {
        $this->view->setMainView('history/index');
    }
}
