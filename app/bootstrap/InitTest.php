<?php
/**
 * Spreadshare
 *
 * App Initialization and DI creation
 *
 * @package DS
 * @version $Version$
 */

use DS\Application;

$di = include_once('Init.php');
$di->set('testing', true);
return Application::initialize($di);