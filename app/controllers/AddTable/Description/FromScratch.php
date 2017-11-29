<?php

namespace DS\Controller\AddTable\Description;

use DS\Api\TableContent;
use DS\Interfaces\TableSubcontrollerInterface;
use DS\Model\Tables;
use League\Csv\Exception;

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
     * @param Tables $table
     * @param int    $userId
     * @param string $param
     *
     * @return $this
     * @throws \Exception
     */
    public function handle(Tables $table, int $userId, string $param)
    {
        try
        {
            $this->view->setVar('hideChooseTable', true);
            $this->view->setVar('content', 'table/add/description');
            $this->view->setVar('action', '/table/add/description/from-scratch');
            $this->view->setVar('tab', 'description');
            
            $createdTableModel = $this->handlePost($userId);
            
            if ($createdTableModel && $createdTableModel->getId())
            {
                try
                {
                    // Adding some empty cells
                    $tableContent = new TableContent();
                    $tableContent->addfromCsvText(
                        $createdTableModel->getId(),
                        'A,B,C,D,E,F
" "," "," "," "," "," ",
" "," "," "," "," "," ",
" "," "," "," "," "," ",
" "," "," "," "," "," ",
" "," "," "," "," "," ",
" "," "," "," "," "," ",
',
                        ',',
                        true
                    );
                } catch (Exception $e)
                {
                    $createdTableModel->delete();
                }
                
                // Table successfully created
                //$this->response->redirect();
                header('Location: /table/add/confirm?tableId=' . $createdTableModel->getId() . '&redirectToTable');
            }
        }
        catch (\Exception $e)
        {
            if (isset($createdTableModel) && $createdTableModel->getId())
            {
                $createdTableModel->delete();
            }
            
            throw $e;
        }
        
        return $this;
    }
}