<?php

namespace DS\Listeners;

use Bernard\Message\PlainMessage;
use DS\Application;
use DS\Component\ServiceManager;
use DS\Model\TableRows;
use Elastica\Exception\NotFoundException;
use Elastica\Exception\ResponseException;
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
            
            $tableRows = new TableRows();
            $rows      = $tableRows->getRowsForTable($message->get('tableId'), 0);
            $content   = implode(
                "\n",
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
                        
                        return str_repeat(',', count($content));
                    },
                    $rows->toArray()
                )
            );
            
            // Create a table
            $tableData = [
                'id' => $message->get('tableId'),
                'title' => $message->get('tableTitle'),
                'tagline' => $message->get('tableTagline'),
                'content' => $content,
            ];
            
            // getClient
            $elasticaClient = self::getClient();
            
            // Load index
            $elasticaIndex = $elasticaClient->getIndex('tables');
            $elasticaType  = $elasticaIndex->getType('table');
            
            // Document addition
            try
            {
                $tableDocument = $elasticaType->getDocument($message->get('tableId'));
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
                $tableDocument = new \Elastica\Document($message->get('tableId'));
            }
            
            // Document addition
            $tableDocument->setData($tableData);
            
            // Add new or update Table
            if ($isUpdate)
            {
                $elasticaClient->updateDocument($tableDocument);
                echo "Updated document.\n";
            }
            else
            {
                $elasticaClient->addDocument($tableDocument);
                echo "Created new document.\n";
                
                // Send notification to slack that there is a new table
                try
                {
                    serviceManager()->getSlack()->to(Application::instance()->getConfig()['slack']['tables-channel'])->send(
                        sprintf('New Table: %s (http://%s/table/%s)', $message->get('tableTitle'), Application::instance()->getConfig()['domain'], $message->get('tableId'))
                    );
                }
                catch (\Exception $e)
                {
                    // not that important..
                }
            }
            
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
     * Get the ElasticSearch Service
     *
     * @return \Elastica\Type
     */
    public static function getClient()
    {
        
        // getClient
        $elasticaClient = ServiceManager::instance()->getElasticSearch();
        
        // Load index
        $elasticaIndex = $elasticaClient->getIndex('tables');
        
        if (!$elasticaIndex->exists())
        {
            # Create index
            $elasticaIndex->create();
        }
        
        // Get type
        return $elasticaIndex->getType('table');
    }
    
}
