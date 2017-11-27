<?php

namespace DS\Controller\Table;

use DS\Controller\BaseController;
use DS\Exceptions\SecurityException;
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
class Stats
    extends BaseController
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
    public function handle(Tables $table, int $userId, string $param)
    {
        try
        {
            if ($table->getOwnerUserId() != $userId)
            {
                throw new SecurityException('You are not allowed to view this section.');
            }
            
            $this->view->setMainView('table/detail/stats');
            $this->view->setVar('selectedPage', 'stats');
        }
        catch (\Exception $e)
        {
            throw $e;
        }
        
        return $this;
    }
}