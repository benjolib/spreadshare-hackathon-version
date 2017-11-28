<?php

namespace DS\Model;

use DS\Events\Table\TabelCellChanged;
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
}
