<?php
namespace DS\Traits;

use DS\Component\ServiceManager;
use Phalcon\Di;

/**
 * Spreadshare
 *
 * DI Injection trait
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component
 */
trait DiInjection
{
    /**
     * @var Di
     */
    protected $di;
    
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * Sets the dependency injector
     *
     * @param Di $dependencyInjector
     */
    public function setDI(\Phalcon\DiInterface $dependencyInjector)
    {
        $this->di = $dependencyInjector;

        return $this;
    }

    /**
     * Returns the internal dependency injector
     *
     * @return Di
     */
    public function getDI()
    {
        return $this->di;
    }

    /**
     * DiInjection constructor.
     *
     * @param Di|\Phalcon\DiInterface $dependencyInjector
     */
    public function __construct(Di $dependencyInjector = null)
    {
        if ($dependencyInjector)
        {
            $this->di = $dependencyInjector;
        }
        else
        {
            $this->di = Di::getDefault();
        }
        
        $this->serviceManager = ServiceManager::instance($this->di);
    }
}
