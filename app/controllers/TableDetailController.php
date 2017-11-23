<?php

namespace DS\Controller;

use DS\Model\DataSource\TableFlags;
use DS\Model\Tables;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
class TableDetailController
    extends BaseController
{
    /**
     * Table Detail
     */
    public function indexAction($tableId = null, $tab = 'table')
    {
        if (!$tableId)
        {
            $this->response->redirect('/');
            
            return;
        }
        
        // Assign table data to UI
        $tableModel = Tables::get($tableId);
        
        $subClass = "DS\\Controller\\Table\\" . ucfirst($tab);
        if (class_exists($subClass))
        {
            $tables = $tableModel->findTablesAsArray(
                $this->serviceManager->getAuth()->getUserId(),
                [
                    $tableId,
                ],
                TableFlags::All
            );
            
            if (isset($tables[0]))
            {
                $this->view->setVar('table', $tables[0]);
            }
            
            /**
             * @var \DS\Interfaces\TableSubcontrollerInterface $subController
             */
            $subController = new $subClass();
            if (is_a($subController, 'DS\Interfaces\TableSubcontrollerInterface'))
            {
                $subController->initialize();
                $subController->handle($tableModel, $this->serviceManager->getAuth()->getUserId());
            }
        }
    }
}
