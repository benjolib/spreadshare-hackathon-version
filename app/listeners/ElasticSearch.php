<?php

namespace DS\Listeners;

use Bernard\Message\PlainMessage;
use DS\Application;
use DS\Component\Elasticsearch\ElasticaClient;
use DS\Component\ServiceManager;
use DS\Model\DataSource\TableFlags;
use DS\Model\Helper\TableFilter;
use DS\Model\TableRows;
use DS\Model\Tables;
use Elastica\Exception\NotFoundException;
use Elastica\Exception\ResponseException;
use Elastica\Index;
use Elastica\Type;
use Phalcon\Logger;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component
 */
class ElasticSearch
{
    
    /**
     * @var ElasticaClient
     */
    private $client = null;
    
    /**
     * @var Index
     */
    private $index = null;
    
    /**
     * @var Type
     */
    private $type = null;
    
    /**
     * @var string
     */
    private $indexName = 'tables';
    
    /**
     * @var string
     */
    private $tableTypeName = 'table';
    
    /**
     * @param int $tableId
     *
     * @return string
     */
    private function prepareTableContent(int $tableId): string
    {
        $tableRows = new TableRows();
        $rows      = $tableRows->getRowsForTable($tableId, 0);
        
        return implode(
            " ",
            array_map(
                function ($row) {
                    $content = json_decode($row['content'], true);
                    if ($content)
                    {
                        return implode(
                            ',',
                            array_map(
                                function ($ar) {
                                    return $ar['content'];
                                },
                                $content
                            )
                        );
                    }
                    
                    return str_repeat(' ', count($content));
                },
                $rows->toArray()
            )
        );
    }
    
    /**
     * @param array $tableData
     *
     * @return bool
     */
    private function updateOrAddToIndex(array $tableData, bool $sendNotification = false): bool
    {
        // getClient
        $elasticTableType = $this->getType();
        
        // Document addition
        try
        {
            $tableDocument = $elasticTableType->getDocument($tableData['id']);
        }
        catch (NotFoundException $e)
        {
            // ..
        }
        
        // New record or update
        $isUpdate = !!$tableDocument;
        
        if (!$isUpdate)
        {
            $isUpdate      = false;
            $tableDocument = new \Elastica\Document($tableData['id']);
        }
        
        // Document addition
        $tableDocument->setData($tableData);
        
        // Add new or update Table
        if ($isUpdate)
        {
            $elasticTableType->updateDocument($tableDocument);
            // echo "Updated document.\n";
            
            if ($sendNotification)
            {
                // Send notification to slack that there was a table update
                try
                {
                    serviceManager()->getSlack()->to(Application::instance()->getConfig()['slack']['tables-channel'])->send(
                        sprintf('Table Settings Updated: %s (http://%s/table/%s)', $tableData['title'], Application::instance()->getConfig()['domain'], $tableData['id'])
                    );
                }
                catch (\Exception $e)
                {
                    // not that important..
                }
            }
        }
        else
        {
            $elasticTableType->addDocument($tableDocument);
            // echo "Created new document.\n";
            
            if ($sendNotification)
            {
                // Send notification to slack that there is a new table
                try
                {
                    serviceManager()->getSlack()->to(Application::instance()->getConfig()['slack']['tables-channel'])->send(
                        sprintf('New Table: %s (http://%s/table/%s)', $tableData['title'], Application::instance()->getConfig()['domain'], $tableData['id'])
                    );
                }
                catch (\Exception $e)
                {
                    // not that important..
                }
            }
        }
        
        return $isUpdate;
    }
    
    /**
     * Touched a table updated content or added a new record
     *
     * @param PlainMessage $message
     *
     * @throws \Phalcon\Exception
     */
    public function touchTable(PlainMessage $message)
    {
        try
        {
            echo "Received request for table \"" . $message->get('tableTitle') . "\".\n";
            
            // Create a table
            $tableData = [
                'id' => $message->get('tableId'),
                'title' => $message->get('tableTitle'),
                'tagline' => $message->get('tableTagline'),
                'content' => $this->prepareTableContent($message->get('tableId')),
            ];
            
            $this->updateOrAddToIndex($tableData, true);
        }
        catch (ResponseException $e)
        {
            $error = $e->getResponse()->getFullError();
            Application::instance()->log($error['type'] . ':' . $error['reason'], Logger::CRITICAL);
            
        }
        catch (\Exception $e)
        {
            echo var_export($e->getMessage(), true);
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
        
    }
    
    /**
     * Recrete non existing documents in elasticsearch
     *
     * @return int
     */
    public function reindex(): int
    {
        $counter = 0;
        
        $allTables = (new Tables())
            ->findTablesAsArray(
                0,
                new TableFilter(),
                TableFlags::Published
            );
        foreach ($allTables as $table)
        {
            $this->updateOrAddToIndex(
                [
                    'id' => $table['id'],
                    'title' => $table['title'],
                    'tagline' => $table['tagline'],
                    'content' => $this->prepareTableContent($table['id']),
                ],
                false
            );
            
            $counter++;
        }
        
        return $counter;
    }
    
    /**
     * @param string $index
     *
     * @return \Elastica\Index
     */
    public function getIndex(): Index
    {
        if (!$this->index)
        {
            $this->index = $this->getClient()->getIndex($this->indexName);;
        }
        
        return $this->index;
    }
    
    /**
     * @param string $index
     * @param string $type
     *
     * @return \Elastica\Type
     */
    public function getType(): Type
    {
        if (!$this->type)
        {
            $this->type = $this->getIndex()->getType($this->tableTypeName);
        }
        
        // Get type
        return $this->type;
    }
    
    /**
     * Get the ElasticSearch Service
     *
     * @return ElasticaClient
     */
    public function getClient()
    {
        if (!$this->client)
        {
            // getClient
            $this->client = ServiceManager::instance()->getElasticSearch();
            
            // Load index
            $elasticaIndex = $this->getIndex();
            
            if (!$elasticaIndex->exists())
            {
                # Create index
                $elasticaIndex->create();
            }
            
        }
        
        return $this->client;
    }
    
    /**
     * ElasticSearch constructor.
     *
     * @param string $indexName
     * @param string $tableTypeName
     */
    public function __construct(string $indexName = 'tables', string $tableTypeName = 'table')
    {
        $this->tableTypeName = $tableTypeName;
        $this->indexName     = $indexName;
    }
    
}
