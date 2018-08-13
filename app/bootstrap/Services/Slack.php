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
return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di) {
    /**
     * Setup Crypt service
     *
     * @return Crypt
     */
    $di->set(
        'slack',
        function () use ($application) {
            return new DS\Services\Slack();
        }
    );
    
};