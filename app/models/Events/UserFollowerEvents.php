<?php

namespace DS\Model\Events;

use DS\Model\Abstracts\AbstractUserFollower;

/**
 * Events for model UserFollower
 *
 * @see https://docs.phalconphp.com/ar/3.2/db-models-events
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
}
