<?php

namespace DS\Component\Wallet;

use GuzzleHttp\Client;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component
 */
abstract class AbstractWallet
{
    /**
     * @var Client|null
     */
    protected $guzzleClient = null;
    
    /**
     * @var string
     */
    private $endpointUrl = '';
    
    /**
     * AbstractWallet constructor.
     *
     * @param string $endpointUrl
     */
    public final function __construct(string $endpointUrl)
    {
        $this->endpointUrl  = $endpointUrl;
        $this->guzzleClient = new Client(
            [
                // Base URI is used with relative requests
                'base_uri' => $endpointUrl,
                // Set Headers
                'headers' => ['Content-Type' => 'application/json'],
                // You can set any number of default request options.
                'timeout' => 2.0,
            ]
        );
    }
}