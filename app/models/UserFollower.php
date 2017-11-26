<?php

namespace DS\Model;

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
     * @param int $userId
     * @param int $followerId
     *
     * @return Abstracts\AbstractTableVotes|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFollower(int $userId, int $followerId)
    {
        return self::findFirst(
            [
                "conditions" => 'userId = ?0 AND followedByUserId = ?1',
                "bind" => [$userId, $followerId],
                "limit" => 1,
            ]
        );
    }
    
    /**
     * @param int $userId
     * @param int $followerId
     *
     * @return UserFollower
     */
    public function toggleFollow(int $userId, int $followerId): UserFollower
    {
        $follower = self::findFollower($userId, $followerId);
        if (!$follower)
        {
            $this->setFollowedByUserId($followerId)
                 ->setUserId($userId)
                 ->create();
        }
        else
        {
            $follower->delete();
        }
        
        return $this;
    }
    
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
        }
        
        return $this;
    }
}
