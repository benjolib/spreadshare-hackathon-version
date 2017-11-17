<?php

namespace DS\Model\Events;

use DS\Events\User\UserTableSubscribed;
use DS\Model\Abstracts\AbstractTableVotes;

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
    public function beforeCreate()
    {
        parent::beforeCreate();
        
        return true;
    }
    
    /**
     * @return bool
     */
    public function beforeSave()
    {
        parent::beforeSave();
        
        return true;
    }
    
    /**
     * After table vote created
     */
    public function afterCreate()
    {
        // trigger Table subscription event
        UserTableSubscribed::after($this->getUserId(), $this->getTableId());
    }
}
