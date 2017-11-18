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
        try
        {
            $userId = $this->serviceManager->getAuth()->getUserId();
            switch ($action)
            {
                case 'empty':
                    $this->view->setMainView('table/add/empty');
                    
                    if ($this->request->isPost())
                    {
                        $topic2Id = $topic1Id = null;
                        
                        $topics = $this->request->getPost('topics', null, '');
                        if (isset($topics[0]))
                        {
                            $topic1Id = $topics[0];
                        }
                        if (isset($topics[1]))
                        {
                            $topic2Id = $topics[1];
                        }

                        $tableApi          = new Table();
                        $createdTableModel = $tableApi->createTable(
                            $userId,
                            (string) $this->request->getPost('title', null, ''),
                            (string) $this->request->getPost('tagline', null, ''),
                            (string) $this->request->getPost('image', '', '/assets/images/dustin.jpg'),
                            (int) $this->request->getPost('type'),
                            (int) $topic1Id,
                            (int) $topic2Id,
                            $this->request->getPost('tags', null, []),
                            $this->request->getPost('location', null, [])
                        );
                        
                        if ($createdTableModel->getId())
                        {
                            // Table successfully created
                            // $this->response->redirect(sprintf('/table/%d', $createdTableModel->getId()));
                            $this->response->redirect('');
                        }
                    }
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
        catch (\Exception $e)
        {
            if ($this->request->isPost())
            {
                $this->view->setVar('post', $this->request->getPost());
            }
            
            $this->flash->error($e->getMessage());
        }
    }
    
}
