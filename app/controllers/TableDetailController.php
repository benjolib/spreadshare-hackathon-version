<?php

namespace DS\Controller;

use DS\Events\Table\TableViewed;
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
    public function indexAction($tableId = null)
    {
        if ($tableId)
        {
            // Assign table data to UI
            $tableModel = new Tables();
            $tables     = $tableModel->findTablesAsArray(
                $this->serviceManager->getAuth()->getUserId(),
                [
                    $tableId,
                ],
                TableFlags::All
            );
            
            if (isset($tables[0]))
            {
                TableViewed::after($this->serviceManager->getAuth()->getUserId(), (int) $tables[0]['id']);
                
                $this->view->setVar('table', $tables[0]);
                $this->view->setMainView('table/table');
                
                return;
            }
        }
        
        $this->response->redirect('/');
        
    }
    
}
