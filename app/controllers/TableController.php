<?php

namespace DS\Controller;

use DS\Api\Table;

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
class TableController
    extends BaseController
{
    /**
     * Table
     */
    public function indexAction($params = [])
    {
        $this->view->setMainView('table/table');
    }
    
    /**
     * Add table
     */
    public function addAction($action = '')
    {
        $userId = $this->serviceManager->getAuth()->getUserId();
        switch ($action)
        {
            case 'empty':
                if ($this->request->isPost())
                {
                    $tableApi          = new Table();
                    $createdTableModel = $tableApi->createTable(
                        $userId,
                        $this->request->getPost('title'),
                        $this->request->getPost('tagline'),
                        $this->request->getPost('image', '', '/assets/images/dustin.jpg'),
                        1,
                        1,
                        2,
                        []
                    );
                    
                    if ($createdTableModel->getId())
                    {
                        // Table successfully created
                        // $this->response->redirect(sprintf('/table/%d', $createdTableModel->getId()));
                        $this->response->redirect('');
                    }
                }
                
                $this->view->setMainView('table/add/empty');
                break;
            case 'csv-import':
                $this->view->setMainView('table/add/csv-import');
                break;
            case 'copy-paste':
                $this->view->setMainView('table/add/copy-paste');
                break;
            default:
                $this->view->setMainView('table/add');
                break;
        }
    }
    
}
