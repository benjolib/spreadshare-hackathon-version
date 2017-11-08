<?php

/**
 * Spreadshare
 *
 * Auth Initialization
 *
 * @package DS
 * @version $Version$
 */
return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di) {
    // Register 'auth'
    $di->setShared(
        \DS\Constants\Services::AUTH,
        function () use ($di) {
            try
            {
                $auth = new \DS\Component\Auth($di);
                
                return $auth;
            }
            catch (\Phalcon\Exception $e)
            {
                die($e->getMessage());
            }
        }
    );
};
