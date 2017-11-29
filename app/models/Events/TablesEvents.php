<?php

namespace DS\Model\Events;

use DS\Events\Table\TableCreated;
use DS\Model\Abstracts\AbstractTables;
use DS\Model\Tables;
use DS\Model\TableStats;

/**
 * Events for model Tables
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
abstract class TablesEvents
    extends AbstractTables
{
    
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
    public function afterCreate()
    {
        // Initialize table stats
        $tableStats = new TableStats();
        $tableStats->setTableId($this->getId())->create();
        
        if ($this instanceof Tables)
        {
            TableCreated::after($this->getOwnerUserId(), $this);
        }
        
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
}
