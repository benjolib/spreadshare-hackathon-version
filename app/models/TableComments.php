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
    public static function getComments(int $tableId, int $parentId = -1, $page = 0, $limit = Paging::endlessScrollPortions)
    {
        $query = self::query()
                     ->columns(
                         [
                             self::class . ".id",
                             self::class . ".parentId",
                             self::class . ".comment",
                             self::class . ".votesCount",
                             self::class . ".createdAt",
                             User::class . ".id AS userId",
                             User::class . ".name AS creator",
                             User::class . ".handle AS creatorHandle",
                             User::class . ".image AS creatorImage",
                         ]
                     )
                     ->innerJoin(User::class, self::class . '.userId = ' . User::class . '.id')
                     ->where(self::class . '.tableId = :tableId:', ['tableId' => $tableId])
                     ->limit((int) $limit, $limit * $page)
                     ->orderBy(self::class . '.id DESC');
        
        if ($parentId === -1)
        {
            $query->andWhere('ISNULL(' . self::class . '.parentId)');
        }
        else
        {
            $query->andWhere(self::class . '.parentId = :parentId:', ['parentId' => $parentId]);
        }
        
        return $query->execute()->toArray() ?: [];
    }
}
