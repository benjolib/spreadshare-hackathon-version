<?php

namespace DS\Controller\AddTable\Description;

use DS\Controller\BaseController;
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
class SheetImport
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
    public function handle(Tables $table, int $userId, string $tab, string $param)
    {
        try
        {
            $this->view->setVar('content', 'table/add/sheet-import');
            $this->view->setVar('action', '/table/add/description/sheet-import');
        }
        catch (\Exception $e)
        {
            throw $e;
        }
        
        return $this;
    }
}