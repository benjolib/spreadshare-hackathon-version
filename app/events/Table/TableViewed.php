<?php

namespace DS\Events\Table;

use DS\Events\AbstractEvent;
use DS\Model\TableStats;
use DS\Model\TableViews;

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
class TableViewed extends AbstractEvent
{
    
    /**
     * Issued after a table has been viewed
     *
     * @param int $userId
     * @param int $tableId
     */
    public static function after(int $userId, int $tableId)
    {
        $tableStats = TableStats::findByFieldValue('tableId', $tableId);
        if ($tableStats)
        {
            $tableStats->setViewsCount($tableStats->getViewsCount() + 1)->save();
            
            if ($userId > 0)
            {
                (new TableViews())->setUserId($userId)->setTableId($tableId)->create();
            }
        }
    }
    
}