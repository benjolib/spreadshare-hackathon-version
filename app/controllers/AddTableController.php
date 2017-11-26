<?php

namespace DS\Controller;

use DS\Api\Table;
use DS\Interfaces\LoginAwareController;
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
    }
    
    /**
     * Table
     */
    public function indexAction($selection = 'choose-method')
    {
        $this->view->setMainView('table/add');
        
        if ($selection === 'from-scratch')
        {
            $this->view->setVar('hideChooseTable', true);
        }
        
        $this->callSubHandler($selection, 'Description', $this->serviceManager->getAuth()->getUserId());
    }
    
    /**
     * @param string $selectionaa
     */
    public function chooseAction($selection)
    {
        $this->view->setMainView('table/add');
        $userId = $this->serviceManager->getAuth()->getUserId();
        
        $this->callSubHandler($selection, 'ChooseTable', $userId);
    }
    
    /**
     * @param string $selection
     * @param string $step
     * @param int    $userId
     */
    private function callSubHandler(string $selection, string $step, int $userId)
    {
        if ($selection)
        {
            // Choose Table Step (onyl applies to copy-poast, csv-import and sheet-import)
            $subClass = "DS\\Controller\\AddTable\\" . $step . "\\" . str_replace(' ', '', ucfirst(str_replace('-', ' ', $selection)));
            if (class_exists($subClass))
            {
                /**
                 * @var \DS\Interfaces\TableSubcontrollerInterface $subController
                 */
                $subController = new $subClass();
                if (is_a($subController, 'DS\Interfaces\TableSubcontrollerInterface'))
                {
                    $subController->initialize();
                    $subController->handle(new Tables(), $userId, '');
                }
            }
        }
    }
    
    /**
     * Handle confirm GET and POST
     */
    public function confirmAction()
    {
        $this->view->setMainView('table/add');
        $userId = $this->serviceManager->getAuth()->getUserId();
        
        $tableId = $this->request->get('tableId');
        $this->view->setVar('action', '/table/add/confirm');
        $this->view->setVar('content', 'table/add/confirm');
        $this->view->setVar('tab', 'confirm');
        
        if ($tableId)
        {
            $tableModel = Tables::get($tableId);
            if ($tableModel->getOwnerUserId() == $userId)
            {
                $this->view->setVar('tableId', $this->request->get('tableId'));
                
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
            }
        }
    }
    
    /**
     * Add table
     */
    public function addActionOld($action = '', $step = 0)
    {
        try
        {
            $this->view->setVar('nextstep', $step + 1);
            
            $userId = $this->serviceManager->getAuth()->getUserId();
            switch ($action)
            {
                case 'empty':
                    $this->view->setMainView('table/add/empty');
                    
                    break;
                case 'csv-import':
                    $this->view->setMainView('table/add/csv-import');
                    
                    if ($this->request->isPost())
                    {
                        switch ($step)
                        {
                            case "1":
                                
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
                    if ($this->request->isPost())
                    {
                        switch ($step)
                        {
                            case "3":
                                try
                                {
                                
                                }
                                catch (\Exception $e)
                                {
                                    $this->view->setVar('nextstep', 1);
                                    throw $e;
                                }
                                break;
                        }
                    }
                    
                    $this->view->setMainView('table/add/copy-paste');
                    break;
                case 'confirm':
                    
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
