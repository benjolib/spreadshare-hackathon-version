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
class TableDataImported extends AbstractEvent
{
    
    /**
     * Issued after a table has been created
     *
     * @param int    $userId
     * @param Tables $table
     */
    public static function after(int $userId, Tables $table)
    {
        
        // Initialize table log with a table created entry
        $tableLog = new TableLog();
        $tableLog->setTableId($table->getId())
                 ->setLogType(TableLogType::DataImported)
                 ->setUserId($userId)
                 ->setPlaceholders('')
                 ->setText('imported data into this table.')
                 ->create();
        
    }
    
}