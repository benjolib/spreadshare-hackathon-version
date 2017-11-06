<?php
namespace DS\Interfaces;

use Phalcon\Config;
use Phalcon\Di;

/**
 * Spreadshare
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version $Version$
 * @package DS\Interfaces
 */
interface GeneralApplication
{
    /**
     * Return config
     *
     * @return Config
     */
    public function getConfig();

    /**
     * Get Di
     *
     * @return Di
     */
    public function getDI();

    /**
     * Get root directory of the app (with ending /)
     *
     * @return string
     */
    public function getRootDirectory();
}
