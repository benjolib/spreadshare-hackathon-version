<?php

namespace DS\Model\Events;

use DS\Model\Abstracts\AbstractUserNotifications;
use DS\Model\UserStats;

/**
 * Events for model UserNotifications
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
abstract class UserNotificationsEvents
    extends AbstractUserNotifications
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
     * After create a user notification
     */
    public function afterCreate()
    {
        UserStats::increment($this->getUserId(), 'unreadNotifications');
    }
}
