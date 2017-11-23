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
class CsvImport
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
            $this->view->setVar('content', 'table/add/csv-import');
            $this->view->setVar('content_js', 'table/add/csv-import.js');
            $this->view->setVar('action', '/table/add/choose/csv-import');
            $this->view->setVar('tab', 'choose-table');
            $this->view->setVar('tableId', $this->request->get('tableId'));
            
            try
            {
                if ($this->request->isPost())
                {
                    if (!$this->request->hasFiles(true))
                    {
                        throw new \InvalidArgumentException('Please upload a valid csv file.');
                    }
                    
                    $csvText = '';
                    $files   = $this->request->getUploadedFiles(true);
                    foreach ($files as $file)
                    {
                        $csvText    = file_get_contents($file->getTempName());
                    }
                    
                    if ($csvText)
                    {
                        $tableId = $this->request->getPost('tableId');
                        
                        $tableContentApi = new TableContent();
                        $tableContentApi->addfromCsvText($tableId, $csvText);
                        
                        // Fire event
                        TableDataImported::after($userId, $table);
                        
                        header('Location: /table/add/confirm?tableId=' . $tableId);
                    }
                }
            }
            catch (\Exception $e)
            {
                $this->view->setVar('nextstep', 1);
                throw $e;
            }
        }
        catch (\Exception $e)
        {
            throw $e;
        }
        
        return $this;
    }
}