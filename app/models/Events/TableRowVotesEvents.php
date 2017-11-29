<?php

namespace DS\Model\Events;

use DS\Events\Table\TableRowUpvoted;
use DS\Model\Abstracts\AbstractTableRowVotes;
use DS\Model\TableRows;

/**
 * Events for model TableRowVotes
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
abstract class TableRowVotesEvents
    extends AbstractTableRowVotes
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
    public function beforeValidationOnUpdate()
    {
        parent::beforeValidationOnUpdate();
        
        return true;
    }
    
    /**
     * After creating a row vote
     */
    public function afterCreate()
    {
        TableRowUpvoted::after($this->getUserId(), (new TableRows())->get($this->getRowId()));
    }
    
    /**
     * After creating a row vote
     */
    public function beforeDelete()
    {
        TableRowUpvoted::after($this->getUserId(), (new TableRows())->get($this->getRowId()));
    }
}
