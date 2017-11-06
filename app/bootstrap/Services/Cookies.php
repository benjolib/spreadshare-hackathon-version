<?php
use Phalcon\Crypt;

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
     * Setup Crypt service
     *
     * @return Crypt
     */
    $di->set(
        'cookies',
        function () use ($application)
        {
            $cookies = new \Phalcon\Http\Response\Cookies();
            $cookies->useEncryption(false);

            return $cookies;
        }
    );

};