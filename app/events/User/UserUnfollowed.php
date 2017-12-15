<?php

namespace DS\Events\User;

use DS\Events\AbstractEvent;
use DS\Model\UserStats;

/**
 * Spreadshare
 *
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Events\Table
 */
class UserUnfollowed extends AbstractEvent
{
    
    /**
     * Issued after a has been followed by another user
     *
     * @param int $userId
     * @param int $followedByUserId
     */
    public static function after(int $userId, int $followedByUserId)
    {
        UserStats::decrement($userId, 'follower');
    }
    
}