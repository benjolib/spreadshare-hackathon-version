<?php

namespace DS\Controller;

use DS\Api\Table;
use DS\Api\TableContent;
use DS\Interfaces\LoginAwareController;
use DS\Model\Tables;
use DS\Model\UserStats;
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
class AddTableController
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
    
    public function addAction()
    {
        $this->view->setMainView('table/add');
        $this->view->setVar('tab', 'choose-method');
        $this->view->setVar('content', 'table/add/choose-method');
        $this->view->setVar('action', '/table/add/description');
        $this->view->setVar('hideChooseTable', false);
        
        // Remember that user visited table add page for first time
        $tableStats = (new UserStats())->get($this->serviceManager->getAuth()->getUserId(), 'userId');
        $this->view->setVar('visitedAddTablePage', $tableStats->getVisitedAddTablePage());
        
        if (!$tableStats->getVisitedAddTablePage())
        {
            $tableStats->setUserId($this->serviceManager->getAuth()->getUserId())->setVisitedAddTablePage(1)->save();
        }
    }
    
    /**
     * Table
     */
    public function indexAction($selection = 'choose-method')
    {
        $this->view->setMainView('table/add');
        $this->view->setVar('hideChooseTable', false);
        
        try
        {
            $this->view->setVar('post', $this->request->getPost());
            
            $userId = $this->serviceManager->getAuth()->getUserId();
            
            if ($selection)
            {
                // Choose Table Step (onyl applies to copy-poast, csv-import and sheet-import)
                $subClass = "DS\\Controller\\AddTable\\Description\\" . str_replace(' ', '', ucwords(str_replace('-', ' ', $selection)));
                if (class_exists($subClass))
                {
                    /**
                     * @var \DS\Interfaces\TableSubcontrollerInterface $subController
                     */
                    $subController = new $subClass();
                    if (is_a($subController, 'DS\Interfaces\TableSubcontrollerInterface'))
                    {
                        $subController->initialize();
                        $subController->handle(/* pass dummy table model */
                            new Tables(),
                            $userId,
                            ''
                        );
                    }
                }
            }
        }
        catch (\Exception $e)
        {
            $this->flash->error($e->getMessage());
        }
    }
    
    /**
     * @param string $selectionaa
     */
    public function chooseAction($selection)
    {
        try
        {
            $this->view->setMainView('table/add');
            $this->view->setVar('hideChooseTable', false);
            $userId = $this->serviceManager->getAuth()->getUserId();
            
            if ($selection)
            {
                $tableId    = $this->request->get('tableId');
                $tableModel = Tables::getInstance($tableId);
                
                if (!$tableModel->getId())
                {
                    throw new Exception('Table does not exist!');
                }
                
                // Choose Table Step (onyl applies to copy-poast, csv-import and sheet-import)
                $subClass = "DS\\Controller\\AddTable\\ChooseTable\\" . str_replace(' ', '', ucwords(str_replace('-', ' ', $selection)));
                if (class_exists($subClass))
                {
                    /**
                     * @var \DS\Interfaces\TableSubcontrollerInterface $subController
                     */
                    $subController = new $subClass();
                    if (is_a($subController, 'DS\Interfaces\TableSubcontrollerInterface'))
                    {
                        $subController->initialize();
                        $subController->handle(isset($tableModel) ? $tableModel : new Tables(), $userId, '');
                    }
                }
            }
        }
        catch (\Exception $e)
        {
            // $this->flash->error($e->getMessage());
            header('Location: /table/add');
        }
    }
    
    /**
     * Handle confirm GET and POST
     */
    public function confirmAction()
    {
        try
        {
            $this->view->setMainView('table/add');
            $userId = $this->serviceManager->getAuth()->getUserId();
            
            $tableId = $this->request->get('tableId');
            $this->view->setVar('action', '/table/add/confirm');
            $this->view->setVar('content', 'table/add/confirm');
            $this->view->setVar('tab', 'confirm');
            
            if ($tableId)
            {
                
                $tableContent = new TableContent();
                $tableData    = $tableContent->getTableData($tableId, $userId);
                $this->view->setVar('tableData', $tableData);
                
                $tableModel = Tables::get($tableId);
                if ($tableModel->getOwnerUserId() == $userId)
                {
                    $this->view->setVar('tableId', $this->request->get('tableId'));
                    $this->view->setVar('redirectToTable', $this->request->get('redirectToTable') === null ? 0 : 1);
                    
                    if ($this->request->isPost())
                    {
                        $tableId = $this->request->getPost('tableId');
                        if ($tableId)
                        {
                            $tableApi = new Table();
                            $tableApi->publish($tableId);
                            
                            $tableApi->fixRowsAndColumns(
                                $tableId,
                                $this->request->getPost('fixedRowsTop', null, ''),
                                $this->request->getPost('fixedColumnsLeft', null, '')
                            );
                            
                            // Now always redirecting to table
                            //if ($this->request->getPost('redirectToTable'))
                            //{
                            header('Location: /table/' . $tableId);
                            //}
                            //else
                            //{
                            //    $this->response->redirect('/');
                            //}
                        }
                    }
                }
            }
        }
        catch (\Exception $e)
        {
            $this->flash->error($e->getMessage());
        }
    }
}
