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
        \DS\Constants\Services::WALLET,
        function () use ($application, $di)
        {
            $config = $application->getConfig();

            $client = new GuzzleHttp\Client([
                // Base URI is used with relative requests
                'base_uri' => $config['wallet'],
                // Set Headers
                'headers' => ['Content-Type' => 'application/json'],
                // You can set any number of default request options.
                'timeout'  => 2.0,
            ]);

            return $client;
        }
    );


    

};
