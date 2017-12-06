<?php

namespace DS\Model\Events;

use DS\Events\Table\TabelCellChangeRequested;
use DS\Events\Table\TabelCellChangeReviewed;
use DS\Exceptions\ModelFieldNotNullException;
use DS\Model\Abstracts\AbstractChangeRequests;
use DS\Model\DataSource\ChangeRequestStatus;
use DS\Model\TableCells;
use DS\Model\TableStats;

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
        
        return $this->beforeValidationOnUpdate();
    }
    
    /**
     * @return bool
     */
    public function beforeValidationOnUpdate()
    {
        parent::beforeValidationOnUpdate();
        
        if (!$this->getUserId())
        {
            throw new ModelFieldNotNullException('Invalid user for change request.');
        }
        
        if (!$this->getCellId())
        {
            throw new ModelFieldNotNullException('Invalid cell for change request.');
        }
        
        return true;
    }
    
    /**
     * Perform cell change if status is confirmed
     */
    public function afterSave()
    {
        if ($this->getStatus() == ChangeRequestStatus::Confirmed && $this->getCellId())
        {
            $cell = TableCells::get($this->getCellId());
            
            // @todo change this to a proper handling with a content type Link or Text.
            if (strpos($this->getTo(), '> Link: ') === 0)
            {
                $cell->setLink(str_replace('> Link: ', '', $this->getTo()));
            }
            else
            {
                $cell->setContent($this->getTo()); // Change content
            }
            
            $cell->setUserId($this->getUserId())// Change cell ownership
                 ->save();
        }
        
        if ($this->getStatus() != ChangeRequestStatus::AwaitingApproval)
        {
            TabelCellChangeReviewed::after($this, $this->tableId);
            (new TableStats)->decrement($this->tableId, 'unconfirmedChanges');
        }
    }
    
    /**
     * After creating the change request
     */
    public function afterCreate()
    {
        (new TableStats)->increment($this->tableId, 'unconfirmedChanges');
        
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
