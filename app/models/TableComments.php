<?php

namespace DS\Model;

use DS\Constants\Paging;
use DS\Model\Events\TableCommentsEvents;

/**
 * TableComments
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
class TableComments
    extends TableCommentsEvents
{
    /**
     * @param int $tableId
     * @param int $page
     * @param int $limit
     *
     * @return array
     */
    public function getComents(int $tableId, $page = 0, $limit = Paging::endlessScrollPortions)
    {
        return self::query()
                   ->columns(
                       [
                           self::class . ".id",
                           self::class . ".comment",
                           self::class . ".votesCount",
                           self::class . ".createdAt",
                           User::class . ".name AS creator",
                           User::class . ".image AS creatorImage",
                       ]
                   )
                   ->innerJoin(User::class, self::class . '.userId = ' . User::class . '.id')
                   ->where(self::class . '.tableId = :tableId:', ['tableId' => $tableId])
                   ->limit((int) $limit, (int) Paging::endlessScrollPortions * $page)
                   ->orderBy(self::class . '.id DESC')
                   ->execute()
                   ->toArray() ?: [];
    }
}
