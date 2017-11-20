<?php

namespace DS\Controller;

use DS\Api\Table;
use DS\Api\TableContent;
use DS\Interfaces\LoginAwareController;

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
    implements LoginAwareController
{
    /**
     * @return bool
     */
    public function needsLogin()
    {
        return true;
    }
    
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
    public function addAction($action = '', $step = 0)
    {
        try
        {
            $this->view->setVar('nextstep', $step + 1);
            
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
                    
                    if ($this->request->isPost())
                    {
                        switch ($step)
                        {
                            case "1":
                                try
                                {
                                    if (!$this->request->hasFiles(true))
                                    {
                                        throw new \InvalidArgumentException('Please upload a valid csv file.');
                                    }
                                    
                                    $csvText = $tableTitle = '';
                                    $files   = $this->request->getUploadedFiles(true);
                                    foreach ($files as $file)
                                    {
                                        $csvText    = file_get_contents($file->getTempName());
                                        $tableTitle = str_replace('.' . $file->getExtension(), '', $file->getName());
                                    }
                                    
                                    if ($tableTitle && $csvText)
                                    {
                                        $tableApi   = new Table();
                                        $tableModel = $tableApi->createTable(
                                            $this->serviceManager->getAuth()->getUserId(),
                                            $tableTitle,
                                            '',
                                            ''
                                        );
                                        
                                        $tableContentApi = new TableContent();
                                        $tableContentApi->addfromCsvText($tableModel->getId(), $csvText);
                                        
                                        $this->view->setVar(
                                            'post',
                                            ['title' => $tableModel->getTitle()]
                                        );
                                        $this->view->setVar('tableId', $tableModel->getId());
                                        $this->view->setVar('action', '/table/add/csv-import/2');
                                        $this->view->setMainView('table/add/empty');
                                    }
                                    
                                }
                                catch (\Exception $e)
                                {
                                    $this->view->setVar('nextstep', 1);
                                    throw $e;
                                }
                                
                                break;
                            case "2":
                                $this->view->setVar('tableId', $this->request->getPost('tableId'));
                                $this->view->setVar('action', '/table/add/confirm');
                                $this->view->setMainView('table/add/confirm');
                                
                                break;
                        }
                        
                    }
                    break;
                case 'copy-paste':
                    $this->view->setMainView('table/add/copy-paste');
                    break;
                case 'confirm':
                    if ($this->request->isPost())
                    {
                        $tableId = $this->request->getPost('tableId');
                        if ($tableId)
                        {
                            $tableApi = new Table();
                            $tableApi->publish($tableId);
                            
                            $this->response->redirect('/');
                        }
                    }
                    break;
                default:
                    $this->view->setVar('tableId', $this->request->getPost('tableId'));
                    $this->view->setVar('action', '/table/add');
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
