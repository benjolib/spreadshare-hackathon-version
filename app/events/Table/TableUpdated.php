<?php

namespace DS\Events\Table;

use DS\Events\AbstractEvent;
use DS\Model\DataSource\TableLogType;
use DS\Model\TableLog;
use DS\Model\Tables;

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
class TableUpdated extends AbstractEvent
{
    
    /**
     * Issued after a table has been modified
     *
     * @param int    $userId
     * @param Tables $table
     */
    public static function after(int $userId, Tables $table)
    {
        
        $tableLog = new TableLog();
        $tableLog
            ->setUserId($userId)
            ->setTableId($table->getId())
            ->setLogType(TableLogType::Updated)
            ->setText('updated table settings.')
            ->setPlaceholders(
                json_encode(
                    [
                        $userId,
                    ]
                )
            )
            ->create();
    }
    
}