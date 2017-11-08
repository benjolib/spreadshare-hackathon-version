<?php
/**
 * Spreadshare
 *
 * Crypt Initialization
 *
 * @package DS
 * @version $Version$
 */
return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di)
{
    /**
     * Setup Notify service
     *
     * @return \DS\Component\Notify
     */
    $di->set(
        'notify',
        function () use ($di)
        {
            return new \DS\Component\Notify($di);
        }
    );

};
