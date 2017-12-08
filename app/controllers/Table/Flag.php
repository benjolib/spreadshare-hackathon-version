<?php

namespace DS\Controller\Table;

use DS\Controller\BaseController;
use DS\Interfaces\TableSubcontrollerInterface;
use DS\Model\TableFlags;
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
class Flag
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
            if ($param)
            {
                if ($this->request->isAjax() && $this->request->isPost())
                {
                    $flags = new TableFlags();
                    $flags->setUserId($this->serviceManager->getAuth()->getUserId())
                          ->setTableId($table->getId())
                          ->setText($this->request->getPost('text'))
                          ->setFlag($param)
                          ->create();
                    
                    $this->response->setContent(
                        json_encode(
                            [
                                'success' => true,
                                'message' => 'Flag request submitted.',
                            ]
                        )
                    )->send();
                    die;
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