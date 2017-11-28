<?php

namespace DS\Events\Table;

use DS\Events\AbstractEvent;
use DS\Model\DataSource\TableLogType;
use DS\Model\Events\TableCellsEvents;
use DS\Model\TableCells;
use DS\Model\TableLog;
use DS\Model\TableRows;
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
     * @param User       $userId User that triggered the change
     * @param TableRows  $row    Row meta data, retrieve the table id from here
     * @param TableCells $cell   The changed table cell
     *
     */
    public static function after(int $userId, TableRows $row, TableCellsEvents $cell)
    {
        /**
         * Update row cache
         *
         * @todo Push this to the queueing instance
         */
        if ($row->getContent())
        {
            $rowData = json_decode($row->getContent(), true);
            if (is_array($rowData))
            {
                foreach ($rowData as $key => $r)
                {
                    if (isset($r['id']) && $r['id'] == $cell->getId())
                    {
                        $rowData[$key] = [
                            "id" => $cell->getId(),
                            "content" => $cell->getContent(),
                            "link" => $cell->getLink(),
                        ];
                        break;
                    }
                }
                
                $row->setContent(json_encode($rowData))->save();
            }
        }
        
        /**
         * Add table log entry
         *
         * @todo could be moved to queue as well..
         */
        $tableLog = new TableLog();
        $tableLog
            ->setUserId($userId)
            ->setTableId($row->getTableId())
            ->setLogType(TableLogType::ContributionCellChanged)
            ->setText('contributed to table (cell content edited).')
            ->setPlaceholders(
                json_encode(
                    [
                        $userId,
                        $cell->getContent(),
                    ]
                )
            )
            ->create();
    }
    
}