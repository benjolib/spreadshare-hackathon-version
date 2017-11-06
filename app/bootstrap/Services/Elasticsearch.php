<?php

/**
 * Spreadshare
 *
 * ElasticSearch Initialization
 *
 * @package DS
 * @version $Version$
 */
return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di)
{
    /**
     * Setup Elastica Client
     *
     * @return
     */
    $di->set(
        \DS\Constants\Services::ELASTICSEARCH,
        function () use ($application, $di)
        {
            $config = $application->getConfig();

            /*
             * Use this for running a cluster:
             *
               array(
                 'servers' => array(
                     array('host' => 'localhost', 'port' => 9200),
                     array('host' => 'localhost', 'port' => 9201)
                 )
               )
             *
             *
             */

            $elasticaClient = new \DS\Component\Elasticsearch\ElasticaClient(
                (array) $config['elasticsearch']
            );
            $elasticaClient->connect();

            // Do not initialize here, since initializing deletes the current index.
            //return $elasticaClient->initialize($di);
            return $elasticaClient;
        }
    );

};
