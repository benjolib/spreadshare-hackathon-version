<?php

namespace DS\Model;

use DS\Model\Events\TableRowsEvents;
use Phalcon\Mvc\Model\Resultset\Simple;

/**
 * TableRows
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 *
 * @method static TableRows findFirstById(int $id)
 */
class TableRows
    extends TableRowsEvents
{
    
    /**
     * @param int $tableId
     *
     * @return Abstracts\AbstractTableRows|Abstracts\AbstractTableRows[]|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public function rebuildRowCache(int $tableId)
    {
        return $this->rebuildRowCacheWithRows(self::findRowsFrom($tableId), $tableId);
    }
    
    /**
     * @param Abstracts\AbstractTableRows|Abstracts\AbstractTableRows[]|\Phalcon\Mvc\Model\ResultSetInterface $rows
     * @param int                                                                                             $tableId
     *
     * @return array
     */
    public function rebuildRowCacheWithRows(Simple $rows, int $tableId)
    {
        foreach ($rows as $row)
        {
            $rowData = [];
            $cells   = TableCells::findCellsByRow($row->getId());
            
            foreach ($cells as $cell)
            {
                $rowData[] = [
                    'id' => $cell['id'],
                    'content' => $cell['content'],
                    'link' => $cell['link'],
                ];
            }
            
            $row->setContent(json_encode($rowData))->save();
        }
        
        return $rows;
    }
    
    /**
     * @param int $tableId
     * @param int $beginningAtRowId
     *
     * @return bool
     */
    public function increaseLineNumbers(int $tableId, int $beginningAtRowId = 0): bool
    {
        return $this->getWriteConnection()->execute(
            'UPDATE tableRows SET lineNumber = lineNumber +1 WHERE (id > :rowId AND tableId = :tableId);',
            ['tableId' => $tableId, 'rowId' => $beginningAtRowId]
        );
    }
    
    /**
     * @param int $tableId
     * @param int $lineNumber
     *
     * @deprecated currently unused, delete maybe
     * @return Abstracts\AbstractTableRows|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findByTableIdAndLineNumber(int $tableId, int $lineNumber)
    {
        return parent::findFirst(
            [
                "conditions" => "tableId = ?0 AND lineNumber = ?1",
                "limit" => 1,
                "bind" => [$tableId, $lineNumber],
            ]
        );
    }
    
    /**
     * @param int $tableId
     * @param int $beginningRowId
     *
     * @return Abstracts\AbstractTableRows|Abstracts\AbstractTableRows[]|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function findRowsFrom(int $tableId, int $beginningRowId = 0)
    {
        return parent::find(
            [
                "conditions" => "tableId = ?0 AND id > ?1",
                "bind" => [$tableId, $beginningRowId],
            ]
        );
    }
    
    /**
     * @param int $tableId
     *
     * @return Simple
     */
    public function getRowsForTable(int $tableId, int $userId)
    {
        $query = self::query()
                     ->columns(
                         [
                             TableRows::class . ".id",
                             TableRows::class . ".content",
                             TableRows::class . ".votesCount",
                             TableRows::class . ".lineNumber",
                             "(SELECT " . TableRowVotes::class . ".createdAt FROM " . TableRowVotes::class . " WHERE " . TableRowVotes::class . ".rowId = " . TableRows::class . ".id AND " . TableRowVotes::class . ".userId = " . $userId . " LIMIT 1) as userHasVoted",
                         ]
                     )
                     ->orderBy(TableRows::class . ".id ASC")
                     ->where(TableRows::class . ".tableId = ?0", [$tableId]);
        
        return $query->execute();
    }
}
