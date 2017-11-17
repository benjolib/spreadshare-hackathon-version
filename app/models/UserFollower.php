<?php

namespace DS\Model;

use DS\Events\Table\UserFollowed;
use DS\Model\Events\UserFollowerEvents;

/**
 * UserFollower
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 *
 * @method static findFirstById(int $id)
 */
class UserFollower
    extends UserFollowerEvents
{
    /**
     * (re-)Set all users followers
     *
     * @param int   $userId
     * @param array $followerUserIds
     *
     * @return $this
     */
    public function overrideFollowerByUserId(int $userId, array $followerUserIds): UserFollower
    {
        // Remove all followers
        $this->getWriteConnection()
             ->delete($this->getSource(), "userId = '{$userId}'");
        
        // .. and recrete them:
        foreach ($followerUserIds as $id)
        {
            (new self())->setUserId($userId)->setFollowedByUserId($id)->create();
            
            // trigger UserFollowed event
            UserFollowed::after($userId, $id);
        }
        
        return $this;
    }
}
