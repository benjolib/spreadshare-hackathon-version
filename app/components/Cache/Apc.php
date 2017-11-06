<?php
namespace DS\Component\Cache;

use Phalcon\Cache\Backend\Apc as BackendCache;
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
class Apc
    extends Provider
{
    /**
     * Apc constructor.
     *
     * @param null|array $options
     */
    public function __construct($options = null)
    {
        $this->cache = new FrontData(
            [
                "lifetime" => 3600
            ]
        );

        $this->backend = new BackendCache(
            $this->cache, $options
        );
    }
}
