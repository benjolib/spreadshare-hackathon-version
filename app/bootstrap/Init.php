<?php
/**
 * Spreadshare
 *
 * App Initialization and DI creation
 *
 * @package DS
 * @version $Version$
 */

use DS\Constants\Services;
use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use Phalcon\Loader;

try
{
    // Directories
    define('APP_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
    define('ROOT_PATH', dirname(APP_PATH) . DIRECTORY_SEPARATOR);

    if (!class_exists('Phalcon\Config'))
    {
        throw new ErrorException('Phalcon is not installed!');
    }

    // Initialize configuration
    $config = new Config(
        include_once APP_PATH . 'config/Config.php'
    );

    // Environment
    define('ENV', isset($config['mode']) ? $config['mode'] : 'production');

    /**
     * Initialize DI Container
     *
     * @global $di
     */
    $di = new FactoryDefault();
    
    // Register an autoloader
    $di['loader'] = new Loader();
    $di['loader']->registerNamespaces((array) $config->get('dirs'))->register();
    
    // Initialize BASE url
    $config['baseurl'] = str_replace('public/index.php', '', $di['request']->getServer('SCRIPT_NAME'));
    
    // Attach config as a service
    $di[Services::CONFIG] = $config;
    
    // Register Whoops if available (only available in dev mode)
    if ($config['mode'] === 'development' && class_exists('Whoops\Provider\Phalcon\WhoopsServiceProvider'))
    {
        new Whoops\Provider\Phalcon\WhoopsServiceProvider($di);
    }
    
    include_once 'Functions.php';
    
    return $di;
}
catch (Exception $e)
{
    die('Error: ' . $e->getMessage());
}