<?php

use DS\Application;
use DS\Constants\Services;
use Phalcon\Config;
use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Logger\Adapter\Stream as StreamAdapter;

ini_set("display_errors", 1);
error_reporting(E_ALL);

define('APP_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(APP_PATH) . DIRECTORY_SEPARATOR);
define('ENV', 'test');

$config = new Config(
    include_once APP_PATH . 'config/TestConfig.php'
);

$di = new FactoryDefault();
$di['loader'] = new Loader();
$di['loader']->registerNamespaces((array) $config->get('dirs'))->register();
$di[Services::CONFIG] = $config;

Di::reset();

// Add any needed services to the DI here

Di::setDefault($di);

$logger = new StreamAdapter('php://stdout');
Application::initializeForTest($di, $logger);

