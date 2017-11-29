<?php

namespace DS\Model;

use DS\Model\Abstracts\AbstractTableCells;
use DS\Model\Events\TableCellsEvents;

/**
 * TableCells
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 *
 * @method static TableCells findFirstById(int $id)
 * @method TableColumns getTableColumns()
 */
class TableCells
    extends TableCellsEvents
{
    /**
     * @param int $columnId
     * @param int $rowId
     *
     * @return AbstractTableCells|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findCellByColumnAndRow(int $columnId, int $rowId)
    {
        return self::findFirst(
            [
                "conditions" => "columnId = ?0 AND rowId = ?1",
                "bind" => [$columnId, $rowId],
                'order' => "columnId ASC",
            ]
        );
    }
    
    /**
     * @param int $rowId
     *
     * @return array
     */
    public static function findCellsByRow(int $rowId): array
    {
        $query = self::query()
                     ->columns(
                         [
                             self::class . ".id",
                             self::class . ".content",
                             self::class . ".link",
                             self::class . ".userId",
                             self::class . ".rowId",
                             self::class . ".columnId",
                             TableColumns::class . ".title as columnTitle",
            
                         ]
                     )
                     ->innerJoin(TableColumns::class, TableColumns::class . '.id = ' . self::class . '.columnId')
                     ->orderBy(TableColumns::class . ".position ASC")
                     ->where(self::class . ".rowId = ?0", [$rowId]);
        
        return $query->execute()->toArray() ?: [];
    }
}
