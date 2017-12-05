<?php

namespace DS\Listeners;

use Bernard\Message\PlainMessage;
use DS\Application;
use DS\Component\ServiceManager;
use Elastica\Exception\ResponseException;
use Phalcon\Logger;

class ElasticSearch
{
    
    public function newTable(PlainMessage $message)
    {
        
        try
        {
            // Create a table
            $tableData = [
                'id' => $message->get('tableId'),
                'title' => $message->get('tableTitle'),
                'tagline' => $message->get('tableTagline'),
            ];
            
            // getClient
            $elasticaClient = self::getClient();
            // Load index
            $elasticaIndex = $elasticaClient->getIndex('tables');
            
            if (!$elasticaIndex->exists())
            {
                # Create index
                $elasticaIndex->create();
            }
            
            // Get type
            $elasticaType = $elasticaIndex->getType('table');
            
            // Document addition
            $tableDocument = $elasticaType->getDocument($message->get('tableId'));
            
            if (!$tableDocument)
            {
                $tableDocument = new \Elastica\Document($message->get('tableId'));
            }
            
            $tableDocument->setData($tableData);
            
            // Add table to type
            $elasticaType->addDocument($tableDocument);
            
        }
        catch (ResponseException $e)
        {
            
            $error = $e->getResponse()->getFullError();
            Application::instance()->log($error['type'] . ':' . $error['reason'], Logger::CRITICAL);
            
        }
        
    }
    
    // Get the ElasticSearch Service
    public static function getClient()
    {
        return ServiceManager::instance()->getElasticSearch();
    }
    
}
