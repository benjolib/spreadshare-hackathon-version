<?php

namespace DS\Model;

use DS\Constants\Paging;
use DS\Model\Events\TablesEvents;

/**
 * Tables
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
class Tables
    extends TablesEvents
{
    /**
     * @param int[] $tableIds
     * @param int   $userId
     * @param int   $page
     * @param int   $limit
     *
     * @return array
     */
    public function findTables(int $userId, array $tableIds = [], int $page = 0, $orderBy = null, $limit = Paging::endlessScrollPortions): array
    {
        $query = self::query()
                     ->columns(
                         [
                             Tables::class . ".id",
                             Tables::class . ".title",
                             Tables::class . ".tagline",
                             TableStats::class . ".votesCount",
                             TableStats::class . ".viewsCount",
                             TableStats::class . ".commentsCount",
                             TableStats::class . ".collaboratorCount",
                             TableStats::class . ".contributionCount",
                             TableStats::class . ".tokensCount",
                             Types::class . ".title as typeTitle",
                             "(SELECT " . TableVotes::class . ".createdAt FROM " . TableVotes::class . " WHERE " . TableVotes::class . ".tableId = " . Tables::class . ".id AND " . TableVotes::class . ".userId = " . $userId . ") as userHasVoted",
                             "(SELECT CUSTOM_GROUP_CONCAT(" . Tags::class . ".title, " . Tags::class . ".title, 'DESC', ', ') FROM " . TableTags::class . " INNER JOIN " . Tags::class . " ON " . Tags::class . ".id = " . TableTags::class . ".tagId WHERE " . TableTags::class . ".tableId = " . Tables::class . ".id) as tags",
                         ]
                     )
                     ->leftJoin(TableStats::class, TableStats::class . '.tableId = ' . Tables::class . '.id')
                     ->leftJoin(Types::class, Tables::class . '.typeId = ' . Types::class . '.id')
                     ->limit((int) $limit, (int) Paging::endlessScrollPortions * $page);
        
        if ($orderBy)
        {
            $query->orderBy($orderBy);
        }
        
        if (count($tableIds))
        {
            $query->inWhere(Tables::class . '.id', $tableIds);
        }
        
        return $query->execute()->toArray() ?: [];
    }
}
