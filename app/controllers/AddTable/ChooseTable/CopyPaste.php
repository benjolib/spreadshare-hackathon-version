<?php

namespace DS\Controller\AddTable\ChooseTable;

use DS\Api\TableContent;
use DS\Controller\BaseController;
use DS\Events\Table\TableDataImported;
use DS\Interfaces\TableSubcontrollerInterface;
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
 * @package   DS\Controller\User
 */
class CopyPaste
    extends BaseController
    implements TableSubcontrollerInterface
{
    
    /**
     * Handle Subcontroller
     *
     * @param Tables $table
     *
     * @return $this
     */
    public function handle(Tables $table, int $userId)
    {
        try
        {
            $this->view->setVar('content', 'table/add/copy-paste');
            $this->view->setVar('action', '/table/add/choose/copy-paste');
            $this->view->setVar('tab', 'choose-table');
            $this->view->setVar('tableId', $this->request->get('tableId'));
            
            if ($this->request->isPost())
            {
                $csvText = $this->request->getPost('data');
                
                if ($csvText)
                {
                    switch ($this->request->getPost('separator'))
                    {
                        case 'comma':
                            $separator = ',';
                            break;
                        case 'semicolon':
                            $separator = ';';
                            break;
                        default:
                        case 'tab':
                            $separator = "\t";
                            break;
                    }
                    
                    $tableId = $this->request->getPost('tableId');
                    
                    if ($tableId)
                    {
                        $tableContentApi = new TableContent();
                        $tableContentApi->addfromCsvText($tableId, $csvText, $separator, !!$this->request->getPost('hasHeaders', null, false));
    
                        // Fire event
                        TableDataImported::after($userId, $table);
    
                        header('Location: /table/add/confirm?tableId=' . $tableId);
                    }
                }
            }
        }
        catch (\Exception $e)
        {
            throw $e;
        }
        
        return $this;
    }
}