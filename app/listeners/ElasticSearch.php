<?php

namespace DS\Listeners;

use DS\Application;
use Elastica\Document;
use Elastica\Exception\ResponseException;
use Elastica\Index;
use Elastica\Response;
use Bernard\Message\PlainMessage;
use DS\Component\ServiceManager;


class ElasticSearch
{


    public function newTable(PlainMessage $message)
    {

      try {

        // Create a table
        $tableData = [
          'id' => $message->get('tableId'),
          'title' => $message->get('tableTitle'),
          'tagline' => $message->get('tableTagline')
        ];

        // getClient
        $elasticaClient = self::getClient();
        // Load index
        $elasticaIndex = $elasticaClient->getIndex('tables');

        if (!$elasticaIndex->exists()) {
          # Create index
          $elasticaIndex->create();
        }

        // Get type
        $elasticaType = $elasticaIndex->getType('table');

        // Document addition
        $tableDocument = new \Elastica\Document($message->get('tableId'), $tableData);

        // Add table to type
        $elasticaType->addDocument($tableDocument);



      } catch (ResponseException $e) {

        $error = $e->getResponse()->getFullError();

        Application::instance()->log($error['type'].':'.$error['reason'], Logger::CRITICAL);

      }

    }


    // Get the ElasticSearch Service
    public static function getClient(){
      return ServiceManager::instance()->getDI()->get('elasticSearch');
    }

}
