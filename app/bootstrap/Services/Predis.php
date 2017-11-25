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
        \DS\Constants\Services::PREDIS,
        function () use ($application, $di)
        {
            $config = $application->getConfig();

            $predisClient = new Predis\Client([
             'host' => $config['redis']['host'],
             'port' => $config['redis']['port']
            ],['prefix' => 'bernard:']);

            return $predisClient;
        }
    );

};
