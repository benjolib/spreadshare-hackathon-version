<?php

namespace DS\Model\Events;

use DS\Events\User\UserFollowed;
use DS\Events\User\UserUnfollowed;
use DS\Model\Abstracts\AbstractUserFollower;

/**
 * Events for model UserFollower
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
abstract class UserFollowerEvents
    extends AbstractUserFollower
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
     * After user follow registered
     */
    public function afterCreate()
    {
        // trigger UserFollowed event
        UserFollowed::after($this->getUserId(), $this->getFollowedByUserId());
    }
    
    /**
     * After user unfollow
     */
    public function afterDelete()
    {
        // trigger UserFollowed event
        UserUnfollowed::after($this->getUserId(), $this->getFollowedByUserId());
    }
}
