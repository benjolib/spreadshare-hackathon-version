<?php

namespace DS\Events\Table;

use DS\Events\AbstractEvent;
use DS\Model\DataSource\TableLogType;
use DS\Model\TableLog;
use DS\Model\Tables;
use DS\Model\User;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Events\Table
 */
class TabelCellChanged extends AbstractEvent
{
    
    /**
     * Issued after the rows of a table has been changed.
     *
     * E.g. a table has been imported from CSV or a change request was accepted.
     *
     * @param User   $userId    User that triggered the change
     * @param Tables $tableId   Table meta data
     * @param string $changedTo Cell content changed to
     *
     */
    public static function after(int $userId, int $tableId, string $changedTo)
    {
        $tableLog = new TableLog();
        $tableLog
            ->setUserId($userId)
            ->setTableId($tableId)
            ->setLogType(TableLogType::ContributionCellChanged)
            ->setText('contributed to table (cell content edited).')
            ->setPlaceholders(
                json_encode(
                    [
                        $userId,
                        $changedTo,
                    ]
                )
            )
            ->create();
    }
    
}