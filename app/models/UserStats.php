<?php

namespace DS\Model;

use DS\Model\Events\UserStatsEvents;
use DS\Traits\Model\UserStatsTrait;

/**
 * UserStats
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
class UserStats
    extends UserStatsEvents
{
    use UserStatsTrait;
    
    /**
     * @param int $userId
     * @param int $limit
     * @param int $page
     *
     * @return array
     */
    public static function getLeaderboard(string $for, $limit = 100)
    {
        if (!$for)
        {
            throw new \InvalidArgumentException('Invalid argument supplied.');
        }
        
        $query = self::query()
                     ->columns(
                         [
                             User::class . ".id",
                             User::class . ".image",
                             User::class . ".name",
                             User::class . ".handle",
                             User::class . ".tagline",
                             User::class . ".location",
                             $for . ' as counter',
                             Wallet::class . '.tokens',
                             self::class . '.tablesOwnerCount',
                             self::class . '.rowsOwnerCount',
                             self::class . '.contributionsCount',
                             self::class . '.upvotesCount',
                             self::class . '.followerCount',
                         ]
                     )
                     ->innerJoin(User::class, self::class . '.userId = ' . User::class . '.id')
                     ->innerJoin(Wallet::class, Wallet::class . '.userId = ' . User::class . '.id')
                     ->groupBy(User::class . '.id')
                     ->limit((int) $limit)
                     ->orderBy($for . ' DESC');
        
        return $query->execute()->toArray() ?: [];
    }
}
