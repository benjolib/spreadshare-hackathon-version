<?php
/**
 * Spreadshare CLI Application
 *
 * @copyright 2016 | DS
 *
 * @version   $Version$
 * @package   DS\Controller
 */
use DS\CliApplication as Application;
use Phalcon\CLI\Console;
use Phalcon\Config;
use Phalcon\Loader;

error_reporting(E_ALL & ~E_NOTICE);

define('VERSION', '1.0.0');
define('APP_PATH', realpath(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR);
define('ROOT_PATH', realpath(dirname(__DIR__)) . DIRECTORY_SEPARATOR);

// Include composer's autoloader
include_once(ROOT_PATH . 'vendor/autoload.php');

// Initialize configuration
$config = new Config(
    include_once ROOT_PATH . 'app/config/Config.php'
);

// Register an autoloader
$di['loader'] = new Loader();
$di['loader']->registerNamespaces((array) $config['dirs'])->register();

// Using the CLI factory default services container
$di = new \Phalcon\Di\FactoryDefault\Cli();

// Attach config as a service
$di[\DS\Constants\Services::CONFIG] = $config;

if (extension_loaded('xdebug') && $config['mode'] !== 'production')
{
    ini_set('xdebug.cli_color', 1);
    ini_set('xdebug.collect_params', 0);
    ini_set('xdebug.dump_globals', 'on');
    ini_set('xdebug.show_local_vars', 'on');
    ini_set('xdebug.show_exception_trace', 'on');
    ini_set('xdebug.max_nesting_level', 100);
    ini_set('xdebug.var_display_max_depth', 4);

    $debug = new \Phalcon\Debug();
    $debug->listen();
}

try
{
    $console = Application::initialize($di);
    $console->setArgs($argv, $argc);

    /**
     * Run cli application
     */
    $console->run();
}
catch (\Phalcon\Exception $e)
{
    echo $e->getMessage();
    exit(255);
}