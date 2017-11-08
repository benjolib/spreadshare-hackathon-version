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
        $this->serviceManager = ServiceManager::instance($this->di);
    }
}
