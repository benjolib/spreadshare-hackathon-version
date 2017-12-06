<?php

/**
 * Spreadshare
 *
 * Wallet Api Initialization
 *
 * @package DS
 * @version $Version$
 */
return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di) {
    /**
     * Setup Wallet
     *
     * @return \DS\Component\Wallet\WalletApi
     */
    $di->set(
        \DS\Constants\Services::WALLETAPI,
        function () use ($application, $di) {
            $config = $application->getConfig();
            
            return new \DS\Component\Wallet\WalletApi($config['wallet']);
        }
    );
};
