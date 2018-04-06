<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;
use DS\Model\DataSource\TableFlags;
use DS\Model\Helper\TableFilter;
use DS\Model\Tables as TablesModel;

class ListsController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function indexAction()
    {
        $user = $this->serviceManager->getAuth()->getUser();

        $filter = TableFlags::All;

        $page = (int) $this->request->get('page', null, 0);
        $limit = 6;

        $tables = (new TablesModel())->selectTables($this->serviceManager->getAuth()->getUserId(), new TableFilter(), $filter, $page, null, $limit)
                                     ->filterOwned((int) $user->getId());

        $tables = $tables->getQuery()->execute()->toArray() ?: [];

        // we fetch 1 more than limit so we can check this
        if (count($tables) > $limit) {
          $tables = array_slice($tables, 0, $limit);
          $this->view->setVar('moreToLoad', true);
        } else {
          $this->view->setVar('moreToLoad', false);
        }

        $this->view->setVar('tables', $tables);

        // Inform view that this is an ajax request
        $this->view->setVar('isAjax', $this->request->isAjax());

        // Paging instead of returning the whole page
        if ($this->request->isAjax() && $this->request->has('page'))
        {
            if (count($tables) === 0)
            {
              // Return nothing if tables are empty for today.
              $this->view->disable();
              header('Content-Type: application/json');
              die(json_encode([
                  'code' => 'no-results'
              ]));
            }
            $this->view->setMainView('lists/content');
        }
        else
        {
            $this->view->setMainView('lists/index');
        }
    }
}
