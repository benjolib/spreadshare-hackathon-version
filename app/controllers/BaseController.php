<?php

namespace DS\Controller;

use DS\Component\ServiceManager;
use Phalcon\Mvc\Controller as PhalconMvcController;

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
abstract class BaseController
    extends PhalconMvcController
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * Initialize controller
     */
    public function initialize()
    {
        if (!$this->serviceManager)
        {
            $this->serviceManager = ServiceManager::instance($this->di);
        }

        $this->view->setVar('base_url', $this->getBaseUrl());

        // Providing the instance to our view
        if (!isset($this->view->auth))
        {
            $this->view->setVar('auth', $this->serviceManager->getAuth());
        }
    }


    function getBaseUrl()
    {
        // output: /myproject/index.php
        $currentPath = $_SERVER['PHP_SELF'];

        // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index )
        $pathInfo = pathinfo($currentPath);

        // output: localhost
        $hostName = $_SERVER['HTTP_HOST'];

        // output: http://
        $protocol = (strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5)) === 'https') ? 'https':'http';

        // return: http://localhost/myproject/
        return $protocol.'://'.$hostName.$pathInfo['dirname'];
    }
}
