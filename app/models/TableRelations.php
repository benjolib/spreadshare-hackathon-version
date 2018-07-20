<?php

namespace DS\Model;

use DS\Constants\Paging;
use DS\Model\Events\TableRelationsEvents;
use DS\Model\TableStaffPicks;
use DS\Model\TableStats;

/**
 * TableRelations
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
class TableRelations extends TableRelationsEvents
{

    /**
     * @param int $tableId
     * @param int $relatedTableId
     *
     * @return Abstracts\AbstractTableRelations|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findRelatedTable(int $tableId, int $relatedTableId)
    {
        return self::findFirst(
            [
                "conditions" => 'tableId = ?0 AND relatedTableId = ?1',
                "bind" => [$tableId, $relatedTableId],
                "limit" => 1,
            ]
        );
    }

    /**
     * @param int $tableId
     * @param int $page
     * @param int $limit
     *
     * @return array
     */
    public function findRelatedTables(int $tableId, $page = 0, $limit = Paging::endlessScrollPortions)
    {
        if ($tableId) {
            return self::query()
                ->columns(
                    [
                        Tables::class . ".id",
                        Tables::class . ".title as name", 
                        Tables::class . ".tagline as slug",
                        Tables::class . ".image",
                        Tables::class . ".description",
                        Tables::class . ".tagline",
                        TableRelations::class . ".createdAt",
                        '(SELECT ' . TableStaffPicks::class . '.createdAt FROM ' . TableStaffPicks::class . ' WHERE ' . TableStaffPicks::class . '.tableId = ' . Tables::class . '.id) as staffPick',
                        User::class . ".handle as curatorHandle",
                        User::class . ".image as curatorImage",
                        User::class . ".name as curatorName",
                        User::class . ".description as curatorBio",
                    ]
                
                )
                ->innerJoin(Tables::class, TableRelations::class . '.relatedTableId = ' . Tables::class . '.id')
                ->innerJoin(User::class, Tables::class . '.ownerUserId = '.User::class.'.id')
                ->where(TableRelations::class . '.tableId = ?0', [$tableId])
                ->limit((int)$limit, (int)Paging::endlessScrollPortions * $page)
                ->orderBy(TableRelations::class . '.createdAt DESC')
                ->execute()
                ->toArray() ?: [];
        }

        return [];
    }
}
