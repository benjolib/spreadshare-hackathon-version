<?php

namespace DS\Model;

use DS\Constants\Paging;
use DS\Model\Events\TableRelationsEvents;

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
class TableRelations
    extends TableRelationsEvents
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
        if ($tableId)
        {
            return self::query()
                       ->columns(
                           [
                               Tables::class . ".id",
                               Tables::class . ".title",
                               Tables::class . ".tagline",
                               TableRelations::class . ".createdAt",
                           ]
                       )
                       ->innerJoin(Tables::class, TableRelations::class . '.relatedTableId = ' . Tables::class . '.id')
                       ->where(TableRelations::class . '.tableId = ?0', [$tableId])
                       ->limit((int) $limit, (int) Paging::endlessScrollPortions * $page)
                       ->orderBy(TableRelations::class . '.createdAt DESC')
                       ->execute()
                       ->toArray() ?: [];
        }
        
        return [];
    }
}
