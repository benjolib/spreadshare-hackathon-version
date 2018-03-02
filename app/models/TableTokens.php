<?php

namespace DS\Model;

use DS\Constants\Paging;
use DS\Model\Events\TableTokensEvents;
use DS\Traits\Model\FindUserAndRowTrait;
use DS\Traits\Model\FindUserAndTableTrait;

/**
 * TableTokens
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
class TableTokens
    extends TableTokensEvents
{
    use FindUserAndRowTrait, FindUserAndTableTrait;

    /**
     * @param int    $userId
     * @param string $orderBy
     * @param int    $page
     * @param int    $limit
     *
     * @return array
     */
    public function getTokens(int $userId, $orderBy = 'tokensEarned', $page = 0, $limit = Paging::endlessScrollPortions)
    {
        if ($userId)
        {
            return self::query()
                       ->columns(
                           [
                               self::class . ".ownership",
                               self::class . ".tokensEarned",
                               self::class . ".type",
                               Tables::class . ".id as tableId",
                               Tables::class . ".title as tableTitle",
                               Tables::class . ".tagline as tableTagline",
                               Tables::class . ".ownerUserId",
                               "(SELECT COUNT(" . TableRows::class . ".id) FROM " . TableRows::class . " WHERE " . TableRows::class . ".tableId = " . Tables::class . ".id) as listingCount",
                               "(SELECT COUNT(" . TableRows::class . ".id) FROM " . TableRows::class . " WHERE " . TableRows::class . ".tableId = " . Tables::class . ".id AND " . TableRows::class . ".userId = " . $userId . ") as yourListingCount"
                           ]
                       )
                       ->innerJoin(Tables::class, TableTokens::class . '.tableId = ' . Tables::class . '.id')
                       ->where(self::class . '.userId = ?0', [$userId])
                       ->andWhere(self::class . ".tokensEarned > 0")
                       ->limit((int) $limit + 1, (int) $limit * $page)
                       ->orderBy(self::class . '.' . $orderBy . ' DESC')
                       ->execute()
                       ->toArray() ?: [];
        }

        return [];
    }
}
