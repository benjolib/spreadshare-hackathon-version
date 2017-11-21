<?php

namespace DS\Events\Table;

use DS\Events\AbstractEvent;
use DS\Model\TableRows;
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
class TableRowsChanged extends AbstractEvent
{
    
    /**
     * Issued after the rows of a table has been changed.
     *
     * E.g. a table has been imported from CSV or a change request was accepted.
     *
     * @param int         $userId           Used that triggered the change
     * @param Tables      $table            Table meta data
     * @param TableRows[] $tableRows        All table rows
     * @param TableRows[] $changedTableRows Only changed table rows
     */
    public static function after(int $userId, Tables $table, array $tableRows, array $changedTableRows)
    {
    
    }
    
}