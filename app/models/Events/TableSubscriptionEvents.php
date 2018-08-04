<?php

namespace DS\Model\Events;

use DS\Events\User\UserTableSubscribed;
use DS\Events\User\UserTableSubscriptionChanged;
use DS\Events\User\UserTableUnsubscribed;
use DS\Model\Abstracts\AbstractTableSubscription;

abstract class TableSubscriptionEvents
    extends AbstractTableSubscription
{
    
    public function beforeValidationOnCreate()
    {
        parent::beforeValidationOnCreate();
        return true;
    }
    
    public function beforeValidationOnUpdate()
    {
        parent::beforeValidationOnUpdate();
        return true;
    }
    
    public function afterCreate()
    {
        UserTableSubscribed::
        after($this->getUserId(), $this->getTableId(), $this->getType());
        return true;
    }
    
    public function afterDelete()
    {
        UserTableUnsubscribed::after($this->getUserId(), $this->getTableId());
        return true;
    }

    public function afterUpdate()
    {
        UserTableSubscriptionChanged::
        after($this->getUserId(), $this->getTableId(), $this->getType());
        return true;
    }
}
