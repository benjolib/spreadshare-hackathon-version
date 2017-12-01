<?php

namespace DS\Model;

use DS\Constants\Paging;
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
     * @return string
     */
    public static function followingSubSelect()
    {
        return "(SELECT " . UserFollower::class . ".id FROM " . UserFollower::class . " WHERE " . UserFollower::class . ".userId = " . User::class . ".id AND " . UserFollower::class . ".followedByUserId = " .
            serviceManager()->getAuth()->getUserId() . ") as following";
    }
    
    /**
     * @param int $userId
     * @param int $limit
     * @param int $page
     *
     * @return array
     */
    public static function findAllFollower(int $userId, $limit = Paging::endlessScrollPortions, $page = 0)
    {
        $query = self::query()
                     ->columns(
                         [
                             User::class . ".id",
                             User::class . ".image",
                             User::class . ".name",
                             User::class . ".handle",
                             User::class . ".tagline",
                             User::class . ".location",
                             self::followingSubSelect(),
                         ]
                     )
                     ->innerJoin(User::class, self::class . '.followedByUserId = ' . User::class . '.id')
                     ->limit((int) $limit, $limit * $page)
                     ->where(self::class . '.userId = ?0', [$userId])
                     ->orderBy(self::class . '.id DESC');
        
        return $query->execute()->toArray() ?: [];
    }
    
    /**
     * @param int $userId
     * @param int $limit
     * @param int $page
     *
     * @return array
     */
    public static function findAllFollowing(int $userId, $limit = Paging::endlessScrollPortions, $page = 0)
    {
        $query = self::query()
                     ->columns(
                         [
                             User::class . ".id",
                             User::class . ".image",
                             User::class . ".name",
                             User::class . ".handle",
                             User::class . ".tagline",
                             User::class . ".location",
                             self::followingSubSelect(),
                         ]
                     )
                     ->innerJoin(User::class, self::class . '.userId = ' . User::class . '.id')
                     ->limit((int) $limit, $limit * $page)
                     ->where(self::class . '.followedByUserId = ?0', [$userId])
                     ->orderBy(self::class . '.id DESC');
        
        return $query->execute()->toArray() ?: [];
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
            (new self())->setUserId($id)->setFollowedByUserId($userId)->create();
        }
        
        return $this;
    }
}
