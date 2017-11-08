<?php

/**
 * Spreadshare
 *
 * Flash Initialization
 *
 * @package DS
 * @version $Version$
 */
return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di) {
    /**
     * Setup Flashbag
     *
     * @return
     */
    $di->set(
        'flash',
        function () use ($application) {
            return new \Phalcon\Flash\Session(
                [
                    "error" => "ui negative aligned message",
                    "success" => "ui positive aligned message",
                    "notice" => "ui info aligned message",
                    "warning" => "ui warning aligned message",
                ]
            );
        }
    );
    
};