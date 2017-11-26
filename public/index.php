<?php
/**
 * Spreadshare
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
use DS\Application;

// Launch phalcon framework only if there is a valid request
if (($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'DELETE' || $_SERVER['REQUEST_METHOD'] === 'PUT'))
{
    // header("Access-Control-Allow-Origin: $httpHost");
    // header('Access-Control-Allow-Credentials: true');
    
    // Include composer's autoloader
    include_once('../vendor/autoload.php');
    
    // Do App Initialization
    $di = include_once('../app/bootstrap/Init.php');
    
    try
    {
        // Handle the request
        $response = Application::initialize($di)->handle();
    }
    catch (Exception $e)
    {
        echo $e->getMessage();die;
        // also store error into file
        @file_put_contents('../system/errors', @file_get_contents('../system/errors') . "\n" . $e->getMessage() . " " . $e->getTraceAsString());
        
        if (!isset($di))
        {
            $di = new \Phalcon\Di\FactoryDefault();
        }
        
        if (!isset($response))
        {
            $response = new \Phalcon\Http\Response();
        }
        
        if (isset($e->xdebug_message))
        {
            $response->setContent('<h1>Error:</h1><p>' . $e->getMessage() . '</p><table>' . $e->xdebug_message . '</table>');
        }
        else
        {
            $response->setContent('There was a problem: ' . $e->getMessage());
        }
        
        $response->setStatusCode(500);
    }
    finally
    {
        // Send response
        if (isset($response) && !$response->isSent())
        {
            $response->send();
        }
    }
}
