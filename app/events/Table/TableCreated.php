<?php

namespace DS\Events\Table;

use DS\Events\AbstractEvent;
use DS\Model\Tables;

/**
 * Spreadshare
 *
 * Table events like views or contributions
 * Used to distribute all actions that are associated with a table
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Events\Table
 *
 * @todo Use Phalcons event engine
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
    
    }
    
}