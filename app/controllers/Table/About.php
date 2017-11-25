<?php

namespace DS\Controller\Table;

use DS\Controller\BaseController;
use DS\Interfaces\TableSubcontrollerInterface;
use DS\Model\TableComments;
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
class About
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
            $comments = new TableComments();
            $this->view->setVar('comments', $comments->getComents($table->getId()));
            
            $this->view->setMainView('table/detail/about');
        }
        catch (\Exception $e)
        {
            throw $e;
        }
        
        return $this;
    }
}