<?php

namespace DS\Events\Table;

use DS\Events\AbstractEvent;
use DS\Model\TableRows;
use DS\Model\Tables;
use DS\Model\TableTokens;

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
class TableRowDownvoted extends AbstractEvent
{
    
    /**
     * @param int       $userId
     * @param TableRows $row
     */
    public static function after(int $userId, TableRows $row)
    {
        $table = Tables::get($row->getTableId());
        
        // Row-votes shouldnt creat tokens!
        /**
         * Delete owners's token on downvote
        $tableToken = TableTokens::findByUserIdAndRow($table->getOwnerUserId(), $row->getId());
        $tableToken->delete();
         * */
    }
    
}