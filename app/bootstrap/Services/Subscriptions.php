<?php

use DS\Component\Subscriptions\SubscriptionsApi;
use DS\Constants\Services;
use GuzzleHttp\Client;

return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di)
{
    $di->set(
        Services::SUBSCRIPTIONS_SERVICE,
        function () use ($application) {
            return new SubscriptionsApi(
                new Client(),
                $application->getConfig()['subscription-service']['url'],
                $application->getConfig()['subscription-service']['apiKey']
            );
        }
    );

};
