<?php

namespace DS\Model\Events;

use DS\Events\Table\TabelCellChangeRequested;
use DS\Model\Abstracts\AbstractChangeRequests;

/**
 * Events for model ChangeRequests
 *
 * @see       https://docs.phalconphp.com/ar/3.2/db-models-events
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 */
abstract class ChangeRequestsEvents
    extends AbstractChangeRequests
{
    private $tableId;
    
    /**
     * @param mixed $tableId
     *
     * @return $this
     */
    public function setTableId($tableId)
    {
        $this->tableId = $tableId;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function beforeValidationOnCreate()
    {
        parent::beforeValidationOnCreate();
        
        return true;
    }
    
    /**
     * @return bool
     */
    public function beforeValidationOnUpdate()
    {
        parent::beforeValidationOnUpdate();
        
        return true;
    }
    
    /**
     * After creating the change request
     */
    public function afterCreate()
    {
        TabelCellChangeRequested::after(
            $this->getUserId(),
            $this->getCellId(),
            $this->tableId,
            $this->getId(),
            $this->getFrom(),
            $this->getTo()
        );
    }
}
