<?php

namespace DS\Controller\AddTable\Description;

use DS\Api\Table;
use DS\Controller\BaseController;
use DS\Events\Table\TableCreated;
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
class FromScratch
    extends BaseDescription
    implements TableSubcontrollerInterface
{
    
    /**
     * Handle Subcontroller
     *
     * @param Tables $table
     * @param int    $userId
     *
     * @return $this
     */
    public function handle(Tables $table, int $userId)
    {
        try
        {
            $this->view->setVar('content', 'table/add/description');
            $this->view->setVar('action', '/table/add/description/from-scratch');
            $this->view->setVar('tab', 'description');
            
            $createdTableModel = $this->handlePost($userId);
            
            if ($createdTableModel && $createdTableModel->getId())
            {
                // Fire event
                TableCreated::after($userId, $table);
                
                // Table successfully created
                //$this->response->redirect();
                header('Location: /table/add/confirm?tableId=' . $createdTableModel->getId());
            }
        }
        catch (\Exception $e)
        {
            throw $e;
        }
        
        return $this;
    }
}