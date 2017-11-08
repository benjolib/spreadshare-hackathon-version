<?php
namespace DS\Component\Cache;

use Phalcon\Cache\BackendInterface;
use Phalcon\Cache\Frontend\Data as FrontData;

/**
 * Spreadshare
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component
 */
abstract class Provider
{
    /**
     * @var FrontData
     */
    protected $cache = null;

    /**
     * @var BackendInterface
     */
    protected $backend = null;

    /**
     * @return FrontData
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @return BackendInterface
     */
    public function getBackend()
    {
        return $this->backend;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function exists($key)
    {
        return $this->backend->exists($key);
    }
    
    /**
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        return $this->backend->exists($key);
    }

    /**
     * Returns a cached content
     *
     * @param int|string $keyName
     * @param int        $lifetime
     *
     * @return mixed
     */
    public function get($key, $lifetime = null)
    {
        return $this->backend->get($key, $lifetime);
    }

    /**
     * Stores cached content into the file backend and stops the frontend
     *
     * @param int|string $keyName
     * @param string     $content
     * @param int        $lifetime
     * @param boolean    $stopBuffer
     *
     * @return $this
     */
    public function set($key, $value = null, $lifetime = null, $stopBuffer = true)
    {
        $this->backend->save($key, $value, $lifetime, $stopBuffer);

        return $this;
    }

}
