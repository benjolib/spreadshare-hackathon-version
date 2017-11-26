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
    public function getTableData(int $tableId)
    {
        $tableRows = new TableRows();
        $rows      = $tableRows->getRowsForTable($tableId);
        
        $columnData = $votesData = $rowData = [];
        foreach ($rows as $row)
        {
            $votesData[] = $row->votesCount;
            $rowData[]   = json_decode($row->content);
        }
        
        $tableColumns = TableColumns::findAllByFieldValue('tableId', $tableId);
        foreach ($tableColumns as $col)
        {
            $columnData[] = $col->getTitle();
        }
        
        return [
            'data' => Tables::get($tableId)->toArray(['title']),
            'votes' => $votesData,
            'columns' => $columnData,
            'rows' => $rowData,
        ];
    }
    
    /**
     * @param int    $tableId
     * @param int    $lineNumber
     * @param string $rowData
     *
     * @return $this
     */
    public function editRow(int $tableId, int $lineNumber, string $rowData)
    {
        if (is_array(json_decode($rowData)))
        {
            $tableRowModel = TableRows::findByTableIdAndLineNumber($tableId, $lineNumber);
            $tableRowModel->setContent($rowData)
                          ->save();
        }
        
        return $this;
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
    public function addfromCsvText(int $tableId, string $csvData = '', $separator = ',', $hasHeaders = false)
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
                            ->setPosition($i)
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
                                 ->setContent(json_encode($row))
                                 ->create();
                        
                        foreach ($row as $key => $cell)
                        {
                            $cellModel = new TableCells();
                            $cellModel->setUserId($userId)
                                      ->setRowId($rowModel->getId())
                                      ->setColumnId($columnIds[$key])
                                      ->setContent($cell)
                                      ->setLink('')// @todo may parse link and add it here
                                      ->create();
                            
                        }
                    }
                }
            }
            
            $db->commit();
        }
        catch (Exception $e)
        {
            $db->rollback();
            throw $e;
        }
        
        return $this;
    }
}