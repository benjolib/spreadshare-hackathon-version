<?php

namespace DS\Api;

use DS\Component\Text\Csv;
use DS\Model\TableCells;
use DS\Model\TableColumns;
use DS\Model\TableRows;
use DS\Model\Tables;
use Phalcon\Exception;

/**
 * Spreadshare
 *
 * Table Content api
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 *
 * @method static findFirstById(int $id)
 */
class TableContent
    extends BaseApi
{
    /**
     * Get table rows, columns, metadata and votes
     *
     * @param int $tableId
     *
     * @return array
     */
    public function getTableData(int $tableId, int $userId): array
    {
        $tableRows = new TableRows();
        $rows      = $tableRows->getRowsForTable($tableId, $userId);
        
        $columnData = $votesData = $rowData = [];
        foreach ($rows as $row)
        {
            $votesData[] = [
                'rowId' => $row['id'],
                'votes' => $row['votesCount'],
                'upvoted' => !!$row['userHasVoted'],
            ];
            $rowData[]   = [
                'id' => $row['id'],
                'content' => json_decode($row->content, true),
            ];
        }
        
        $tableColumns = TableColumns::findAllByFieldValue('tableId', $tableId);
        foreach ($tableColumns as $col)
        {
            $columnData[] = [
                'id' => $col->getId(),
                'title' => $col->getTitle(),
            ];
        }
        
        return [
            'table' => Tables::get($tableId)->toArray(['title']),
            'votes' => $votesData,
            'columns' => $columnData,
            'rows' => $rowData,
        ];
    }
    
    /**
     * @param int    $cellId
     * @param string $content
     * @param string $link
     *
     * @return TableContent
     */
    public function editCell(int $cellId, string $content, string $link): TableContent
    {
        $cellModel = (TableCells::findFirstById($cellId));
        
        if ($cellModel)
        {
            $cellModel->setContent($content)
                      ->setLink($link ?: null)
                      ->save();
        }
        
        return $this;
    }
    
    /**
     * Adds a new row
     *
     * @param int   $tableId
     * @param array $rowData
     * @param int   $insertAfterRowId Set to 0 if you want to add the row to the top
     *
     * @return TableRows
     */
    public function addRow(int $tableId, array $rowData, int $insertAfterRowId = 0): TableRows
    {
        try
        {
            $newRow = new TableRows();
            $newRow->getWriteConnection()->begin();
            
            if (count($rowData))
            {
                // $allRowsForTable = TableRows::findRowsFrom($tableId, $insertAfterRowId ? $insertAfterRowId : 0);
                
                $newRow->increaseLineNumbers($tableId, $insertAfterRowId);
                
                $newRow = $newRow
                    ->setTableId($tableId)
                    ->setUserId($this->serviceManager->getAuth()->getUserId());
                
                if (!$insertAfterRowId)
                {
                    $newRow->setLineNumber(1);
                }
                else
                {
                    $afterRow = TableRows::findFirstById($insertAfterRowId);
                    
                    if (!$afterRow)
                    {
                        throw new \InvalidArgumentException('The given rowId does not exist.');
                    }
                    $newRow->setLineNumber($afterRow->getLineNumber() + 1);
                }
                $newRow->create();
                
                $columns = TableColumns::findAllByFieldValue('tableId', $tableId);
                
                $rowContent = [];
                foreach ($rowData as $key => $row)
                {
                    $cell = new TableCells();
                    $cell->setRowId($newRow->getId())
                         ->setContent($row)
                         ->setLink('')
                         ->setColumnId(isset($columns[$key]) ? $columns[$key]->getId() : null)
                         ->setUserId($newRow->getUserId())
                         ->create();
                    
                    $rowContent[] = [
                        'id' => $cell->getId(),
                        'content' => $cell->getContent(),
                        'link' => $cell->getLink(),
                    ];
                }
                
                $newRow->setContent(json_encode($rowContent))->save();
                
                $newRow->getWriteConnection()->commit();
            }
        }
        catch (\Exception $e)
        {
            $newRow->getWriteConnection()->rollback();
            
            throw $e;
        }
        
        return $newRow;
    }
    
    /**
     * @param int    $tableId
     * @param int    $rowId
     * @param string $rowData
     *
     * @deprecated, use editCell
     * @return $this
     */
    public function editRow(int $tableId, int $rowId, string $rowData): TableContent
    {
        $rowDataArray = json_decode($rowData);
        if (is_array($rowDataArray))
        {
            $tableRowModel = TableRows::findFirstById($rowId);
            $tableRowModel->setContent($rowData)
                          ->save();
        }
        
        return $this;
    }
    
    /**
     * Add a cell and return data for tableRows.content
     *
     * @param TableRows $rowModel
     * @param int       $userId
     * @param int       $columnId
     * @param string    $cell
     * @param string    $link
     *
     * @return array
     */
    private function addCell(TableRows $rowModel, int $userId, int $columnId, string $cell, string $link = ''): array
    {
        $cellModel = new TableCells();
        $cellModel->setUserId($userId)
                  ->setUpdatedById($userId)
                  ->setRowId($rowModel->getId())
                  ->setColumnId($columnId)
                  ->setContent($cell)
                  ->setLink($link)
                  ->create();
        
        return [
            'id' => $cellModel->getId(),
            'content' => $cellModel->getContent(),
            'link' => $cellModel->getLink() ? $cellModel->getLink() : null,
        ];
    }
    
    /**
     * @param int    $tableId
     * @param string $csvData
     * @param string $separator
     * @param bool   $hasHeaders
     *
     * @return $this|TableContent
     * @throws Exception
     */
    public function addfromCsvText(int $tableId, string $csvData = '', $separator = ',', $hasHeaders = false): TableContent
    {
        $userId = serviceManager()->getAuth()->getUserId();
        
        $csv  = new Csv();
        $rows = $csv->parseFromText($csvData, $separator, true, true);
        
        if (!is_array($rows) || !isset($rows[0]))
        {
            throw new \InvalidArgumentException('Unable to parse csv file.');
        }
        
        // Check for semicolon separated text
        if (count($rows[0]) === 1 && substr_count($rows[0][0], ';') > 0)
        {
            return $this->addfromCsvText($tableId, $csvData, ';', $hasHeaders);
        }
        
        // Start sql transaction
        $db = $this->serviceManager->getDI()->get('db');
        $db->begin();
        
        try
        {
            $columnIds = [];
            $i         = 1;
            foreach ($rows[0] as $key => $headerField)
            {
                $columnModel = new TableColumns();
                $columnModel->setTableId($tableId)
                            ->setPosition($i++)
                            ->setUserId($userId)
                            ->setWidth(100)
                            ->setTitle($hasHeaders ? $headerField : 'Column ' . $i++)
                            ->create();
                
                $columnIds[$key] = $columnModel->getId();
            }
            
            if ($hasHeaders)
            {
                unset($rows[0]);
            }
            
            if (count($columnIds))
            {
                // Clear first if there is data already imported
                (new TableRows())->deleteByFieldValue('tableId', $tableId);
                
                $line = 1;
                foreach ($rows as $row)
                {
                    if (is_array($row))
                    {
                        $rowModel = new TableRows();
                        $rowModel->setUserId($userId)
                                 ->setTableId($tableId)
                                 ->setLineNumber($line++)
                                 ->setCommentsCount(0)
                                 ->setVotesCount(0)
                                 ->create();
                        
                        $cellData = [];
                        foreach ($columnIds as $key => $colId)
                        {
                            $cellData[] = $this->addCell(
                                $rowModel,
                                $userId,
                                $colId,
                                isset($row[$key]) && $row[$key] !== null ? $row[$key] : '',
                                ''
                            );
                            
                            $rowModel->setContent(json_encode($cellData))
                                     ->save();
                        }
                    }
                }
            }
            
            $db->commit();
        }
        catch (\Exception $e)
        {
            $db->rollback();
            
            throw $e;
        }
        
        return $this;
    }
}