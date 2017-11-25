<?php

namespace DS\Events\Table;

use DS\Events\AbstractEvent;
use DS\Model\DataSource\TableLogType;
use DS\Model\TableLog;
use DS\Model\Tables;
use DS\Modules\Bernard;

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
 *
 * @todo      Use Phalcons event engine
 */
class TableCreated extends AbstractEvent
{

    /**
     * Issued after a table has been created
     *
     * @param int    $userId
     * @param Tables $table
     */
    public static function after(int $userId, Tables $table)
    {

      Bernard::produce('newTable',[
        'userId' => $userId
      ]);

        // Initialize table log with a table created entry
        $tableLog = new TableLog();
        $tableLog->setTableId($table->getId())
                 ->setLogType(TableLogType::Created)
                 ->setUserId($userId)
                 ->setPlaceholders('')
                 ->setText('Table created.')
                 ->create();
    }

}
