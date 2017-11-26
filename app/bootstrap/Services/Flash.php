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
                    "error" => "flash flash-error",
                    "success" => "flash flash-success",
                    "notice" => "flash flash-notice",
                    "warning" => "flash flash-warning",
                ]
            );
        }
    );

};
