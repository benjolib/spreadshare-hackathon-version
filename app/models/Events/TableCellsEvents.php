<?php

namespace DS\Model\Events;

use DS\Events\Table\TabelCellChanged;
use DS\Model\Abstracts\AbstractTableCells;
use DS\Model\TableRows;

/**
 * Events for model TableCells
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
abstract class TableCellsEvents
    extends AbstractTableCells
{
    /**
     * @var int
     */
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
    
    public function afterSave()
    {
        TabelCellChanged::after(
            $this->getUserId(),
            (TableRows::get($this->getRowId())->getTableId()),
            $this->getContent()
        );
    }
}
