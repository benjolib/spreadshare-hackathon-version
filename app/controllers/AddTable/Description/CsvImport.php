<?php

namespace DS\Controller\AddTable\Description;

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
    extends BaseDescription
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
            $this->view->setVar('content', 'table/add/description');
            $this->view->setVar('action', '/table/add/description/csv-import');
            $this->view->setVar('tab', 'description');
            
            $createdTableModel = $this->handlePost($userId);
            if ($createdTableModel && $createdTableModel->getId())
            {
                // Table successfully created
                //$this->response->redirect();
                header('Location: /table/add/choose/csv-import?tableId=' . $createdTableModel->getId());
            }
        }
        catch (\Exception $e)
        {
            throw $e;
        }
        
        return $this;
    }
}