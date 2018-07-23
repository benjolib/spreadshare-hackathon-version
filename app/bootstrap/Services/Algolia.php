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
            $algoliaConfig = $application->getConfig()['algolia'];

            $client = new \AlgoliaSearch\Client($algoliaConfig['app-id'], $algoliaConfig['api-key']);

            return $client;
        },
        true
    );
};
