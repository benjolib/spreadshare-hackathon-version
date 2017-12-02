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

    /**
     * Touched a table updated content or added a new record
     * @param  PlainMessage $message
     * @return void or error
     */
    public function touchTable(PlainMessage $message)
    {

      try {

        // New record or update
        $isUpdate = $message->get('isUpdated');

        // Create a table
        $tableData = [
          'id' => $message->get('tableId'),
          'title' => $message->get('tableTitle'),
          'tagline' => $message->get('tableTagline')
        ];

        // getClient
        $elasticaClient = self::getClient();

        // Document addition
        $tableDocument = new \Elastica\Document($message->get('tableId'), $tableData);

        // Add new or update Table
        if ($isUpdate) {
          $elasticaClient->updateDocument($tableDocument);
        } else {
          $elasticaClient->addDocument($tableDocument);
        }


      } catch (ResponseException $e) {

        echo "error";

        $error = $e->getResponse()->getFullError();

        Application::instance()->log($error['type'].':'.$error['reason'], Logger::CRITICAL);

      }

    }

    // Get the ElasticSearch Service
    public static function getClient(){

      // getClient
      $elasticaClient = ServiceManager::instance()->getDI()->get('elasticSearch');

      // Load index
      $elasticaIndex = $elasticaClient->getIndex('tables');

      if (!$elasticaIndex->exists()) {
        # Create index
        $elasticaIndex->create();
      }

      // Get type
      return $elasticaIndex->getType('table');

    }

}
