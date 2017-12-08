<?php

namespace DS\Controller;

use DS\Model\DataSource\TableFlags;
use DS\Model\Helper\TableFilter;
use DS\Model\Tables;
use DS\Model\TableStats;
use Phalcon\Exception;

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
    public function indexAction($tableId = null, $tab = 'table', $param = '')
    {
        if (!$tableId)
        {
            $this->response->redirect('/');
            
            return;
        }
        
        // Assign table data to UI
        $tableModel = Tables::get($tableId);
        
        // Check if table is deleted
        if ($tableModel->getFlags() == TableFlags::Deleted)
        {
            throw new Exception('This table has been deleted!');
        }
        
        if ($tableModel->getFlags() == TableFlags::Archived)
        {
            throw new Exception('This table has been archived! It was maybe flagged as inappropriate content.');
        }
        
        // Assign tablestats (e.g. for changelog notification badge)
        $this->view->setVar('tableStats', (new TableStats)->get($tableId, 'tableId'));
        
        $subClass = "DS\\Controller\\Table\\" . ucfirst($tab);
        if (class_exists($subClass))
        {
            $tables = $tableModel->findTablesAsArray(
                $this->serviceManager->getAuth()->getUserId(),
                (new TableFilter)->addTableId($tableId),
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
                $subController->handle($tableModel, $this->serviceManager->getAuth()->getUserId(), $tab, $param);
            }
        }
    }
}
