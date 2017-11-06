<?php
/**
 * Spreadshare Application
 *
 * Initialize framework
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   tests
 */
error_reporting(E_ALL);

if (extension_loaded('xdebug'))
{
    ini_set('xdebug.cli_color', 1);
    ini_set('xdebug.collect_params', 0);
    ini_set('xdebug.dump_globals', 'on');
    ini_set('xdebug.show_local_vars', 'on');
    ini_set('xdebug.max_nesting_level', 100);
    ini_set('xdebug.var_display_max_depth', 4);
}

// Beanstalk
define('TEST_BT_HOST', getenv('TEST_BT_HOST') ?: 'queue');
define('TEST_BT_PORT', getenv('TEST_BT_PORT') ?: 11300);

// MySQL
define('TEST_DB_HOST', getenv('TEST_DB_HOST') ?: 'localhsot');
define('TEST_DB_PORT', getenv('TEST_DB_PORT') ?: 3306);
define('TEST_DB_USER', getenv('TEST_DB_USER') ?: 'root');
define('TEST_DB_PASSWD', getenv('TEST_DB_PASSWD') ?: '');
define('TEST_DB_NAME', getenv('TEST_DB_NAME') ?: 'spreadshare_tests');
define('TEST_DB_CHARSET', getenv('TEST_DB_CHARSET') ?: 'utf8');

clearstatcache();

require_once __DIR__ . '/../../vendor/autoload.php';
$di = require_once(__DIR__ . '/../../app/bootstrap/Init.php');

\Phalcon\Di::reset();
\Phalcon\Di::setDefault($di);
\DS\Application::initialize($di);

// require_once 'AbstractDSTester.php';
