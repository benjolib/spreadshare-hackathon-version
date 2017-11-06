<?php
namespace DS\Component\Cache;

use Phalcon\Cache\Backend\Libmemcached as MemcacheBackend;
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
class Memcache
    extends Provider
{
    /**
     * Memcache constructor.
     *
     * @param array $servers
     */
    public function __construct(array $servers, $prefix = null)
    {
        $this->cache = new FrontData(
            [
                "lifetime" => 86400
            ]
        );

        $this->backend = new MemcacheBackend(
            $this->cache, [
                "servers" => $servers
            ]
        );
    }
}
