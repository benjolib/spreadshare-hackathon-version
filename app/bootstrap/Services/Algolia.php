<?php

/**
 * Spreadshare
 *
 * Algolia Initialization
 *
 * @package DS
 * @version $Version$
 */
return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di)
{
    /**
     * Setup Algolia Client
     *
     * @return
     */
    $di->set(
        \DS\Constants\Services::ALGOLIA,
        function () use ($application, $di)
        {
            $config = $application->getConfig();
            $algoliaConfig = $config['algolia'];

            $client = new \AlgoliaSearch\Client($algoliaConfig['application_id'], $algoliaConfig['admin_api_key']);

            return $client;
        },
        true
    );
};
