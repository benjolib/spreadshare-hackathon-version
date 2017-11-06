<?php
/**
 * Spreadshare
 *
 * Intl Service Initialization
 *
 * This services needs the router services from DI.
 *
 * @package DS
 * @version $Version$
 */
use DS\Component\Intl;

return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di)
{
    // Setup Intl Component
    $di['intl'] = function () use ($di)
    {
        $intl = new Intl();
        $intl->setDI($di);

        return $intl->init();
    };
};