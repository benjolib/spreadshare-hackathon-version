<?php
namespace DS\Component\Cache;

use Phalcon\Cache\Backend\Redis as RedisBackend;
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
class Redis
    extends Provider
{
    /**
     * Redis constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->cache   = new FrontData(["lifetime" => 604800]);
        $this->backend = new RedisBackend(
            $this->cache, $options
        );
    }
}
