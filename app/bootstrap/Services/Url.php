<?php
/**
 * Spreadshare
 *
 * URL Service Initialization
 *
 * @package DS
 * @version $Version$
 */
use Phalcon\Mvc\Url;

return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di)
{
    $config = $application->getConfig();

    // Setup a base URL
    $di['url'] = function () use ($config)
    {
        $url = new Url();
        $url->setBaseUri($config->get('baseurl', '/'));

        return $url;
    };
};