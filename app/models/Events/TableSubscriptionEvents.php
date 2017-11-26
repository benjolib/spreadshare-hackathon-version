<?php

namespace DS\Model\Events;

use DS\Events\User\UserTableSubscribed;
use DS\Events\User\UserTableUnsubscribed;
use DS\Model\Abstracts\AbstractTableSubscription;

/**
 * Events for model TableSubscription
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
abstract class TableSubscriptionEvents
    extends AbstractTableSubscription
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
     * @return bool
     */
    public function afterCreate()
    {
        // trigger Table subscription event
        UserTableSubscribed::after($this->getUserId(), $this->getTableId());
        
        return true;
    }
    
    /**
     * @return bool
     */
    public function afterDelete()
    {
        // trigger Table unsubscription event
        UserTableUnsubscribed::after($this->getUserId(), $this->getTableId());
        
        return true;
    }
}
