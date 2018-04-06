<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;

class ForYouController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function indexAction()
    {
        $this->view->setVar('forYouActive', true);

        $this->view->setMainView('for-you/index');
    }
}
