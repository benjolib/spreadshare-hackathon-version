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

            $tables = (new TablesModel())->selectTables($this->serviceManager->getAuth()->getUserId(), new TableFilter(), $filter, 0)
                                         ->filterOwned((int) $user->getId());

            $this->view->setVar('tables', $tables->getQuery()->execute()->toArray() ?: []);

            $this->view->setMainView('user/tables/tables');
        }
        catch (\Exception $e)
        {
            throw $e;
        }

        return $this;
    }
}
