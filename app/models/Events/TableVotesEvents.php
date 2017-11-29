<?php

namespace DS\Model\Events;

use DS\Events\Table\TableDownvoted;
use DS\Events\Table\TableUpvoted;
use DS\Model\Abstracts\AbstractTableVotes;
use DS\Model\TableStats;

/**
 * Events for model TableVotes
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
abstract class TableVotesEvents
    extends AbstractTableVotes
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
     * After table vote created
     */
    public function afterCreate()
    {
        (new TableStats)->increment($this->getTableId(), 'votes');
        
        // trigger Table upvote event
        TableUpvoted::after($this->getUserId(), $this->getTableId());
    }
    
    /**
     * After table vote created
     */
    public function afterDelete()
    {
        (new TableStats)->decrement($this->getTableId(), 'votes');
        
        // trigger Table downvote event
        TableDownvoted::after($this->getUserId(), $this->getTableId());

    }
}
