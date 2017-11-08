<?php
namespace DS\Model\Manager;

use DS\Constants\Services;
use Phalcon\DiInterface;
use Phalcon\Mvc\Model\Manager as ModelManager;
use Phalcon\Tag;

/**
 * Spreadshare
 *
 * Cache reusable models into a cache system like apc, redis or memcache
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 */
class CachedReusableModelsManager
    extends ModelManager
{
    /**
     * @var \Phalcon\Cache\Backend\Memcache
     */
    public $cache = null;

    /**
     * Returns a reusable object from the cache
     *
     * @param string $modelName
     * @param string $key
     *
     * @return object
     */
    public function getReusableRecords($modelName, $key)
    {
        if ($this->cache->has($key))
        {
            return $this->cache->get($key);
        }

        // For the rest, use the memory cache
        return parent::getReusableRecords($modelName, $key);
    }

    /**
     * Stores a reusable record in the cache
     *
     * @param string $modelName
     * @param string $key
     * @param mixed  $records
     */
    public function setReusableRecords($modelName, $key, $records)
    {
        $this->cache->set($key, $records);

        parent::setReusableRecords($modelName, $key, $records);
    }

    /**
     * Construct
     *
     * @param DiInterface $di
     */
    public function __construct(DiInterface $di)
    {
        $this->setDI($di);
        $this->cache = $di->get(Services::MEMCACHE);
    }
}
