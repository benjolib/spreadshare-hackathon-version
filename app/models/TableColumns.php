<?php

namespace DS\Model;

use DS\Model\Events\TableColumnsEvents;

/**
 * TableColumns
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 *
 * @method static TableColumns findFirstById(int $id)
 */
class TableColumns
    extends TableColumnsEvents
{
    /**
     * @param int $tableId
     *
     * @return bool
     */
    public function clear(int $tableId): bool
    {
        return $this->deleteByFieldValue('tableId', $tableId);
    }
    
    /**
     * @param int    $userId
     * @param int    $tableId
     * @param string $title
     *
     * @return array
     */
    public function add(int $userId, int $tableId, string $title): array
    {
        // @todo optimize this for better performance:
        $columns   = self::findAllByFieldValue('tableId', $tableId);
        $latestCol = $columns[count($columns) - 1];
        
        $this->setUserId($userId)
             ->setTitle($title)
             ->setTableId($tableId)
             ->setPosition($latestCol->getPosition() + 1)
             ->setWidth(100)
             ->create();
        
        $rows = TableRows::findRowsFrom($tableId);
        
        $createdCells = [];
        foreach ($rows as $row)
        {
            $cell = new TableCells();
            $cell->setContent('')
                 ->setLink('')
                 ->setRowId($row->getId())
                 ->setColumnId($this->getId())
                 ->setUpdatedById($userId)
                 ->setUserId($userId)
                 ->create();
            
            $createdCells[] = [
                'id' => $cell->getId(),
                'rowId' => $row->getId(),
            ];
        }
        
        // Recreate cache
        (new TableRows())->rebuildRowCacheWithRows($rows, $tableId);
        
        return [
            'colId' => $this->getId(),
            'cells' => $createdCells,
        ];
    }
    
    /**
     * @param array $param
     * @param int   $page
     * @param int   $limit
     *
     * @return array
     */
    /*
    public function findCustom($param = [], $page = 0, $limit = Paging::endlessScrollPortions)
    {
        if (count($param))
        {
            return self::query()
                       ->columns(
                           [
                               TableColumns::class . ".id",
                           ]
                       )
                //->leftJoin(TableColumns::class, TableColumns::class . '.profileId = ' . Profile::class . '.id')
                //->inWhere(Profile::class . '.id', $param)
                       ->limit((int) $limit, (int) Paging::endlessScrollPortions * $page)
                //->orderBy(sprintf('FIELD (id,%s)', implode(',', $param)))
                       ->execute()
                       ->toArray() ?: [];
        }
        
        return [];
    }
    */
}
