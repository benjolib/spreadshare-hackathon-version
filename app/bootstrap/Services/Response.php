<?php
/**
 * Spreadshare
 *
 * Global response service
 *
 * @package DS
 * @version $Version$
 */
return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di)
{
    $di->set(
        'response',
        function () use ($di)
        {
            return new \Phalcon\Http\Response();
        }
    );
};