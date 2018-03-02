<?php

namespace DS\Controller\User;

use DS\Controller\BaseController;
use DS\Interfaces\UserSubcontrollerInterface;
use DS\Model\DataSource\TableFlags;
use DS\Model\Helper\TableFilter;
use DS\Model\Tables as TablesModel;
use DS\Model\User;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller\User
 */
class Tables
    extends BaseController
    implements UserSubcontrollerInterface
{

    /**
     * Handle Subcontroller
     *
     * @param User $user
     *
     * @return $this
     */
    public function handle(User $user)
    {
        try
        {
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
                $this->view->setMainView('user/tables/tables');
            }
            else
            {
                $this->view->setMainView('user/tables/index');
            }
        }
        catch (\Exception $e)
        {
            throw $e;
        }

        return $this;
    }
}
