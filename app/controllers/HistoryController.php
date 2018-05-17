<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;
use DS\Model\DataSource\TableFlags;
use DS\Model\Helper\TableFilter;
use DS\Model\Tables;
use DS\Model\User;

class HistoryController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function indexAction()
    {
      $user = $this->serviceManager->getAuth()->getUser();
      
      $tables = (new Tables())->selectTables($this->serviceManager->getAuth()->getUserId(), new TableFilter(), TableFlags::Published, 0)
                              ->filterHistory((int) $user->getId());

      $this->view->setVar('tables', $tables->getQuery()->execute()->toArray() ?: []);

        $this->view->setMainView('history/index');
    }
}
