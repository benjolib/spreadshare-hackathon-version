<?php
namespace DS\Component;

use Phalcon\Tag;

/**
 * Spreadshare
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version $Version$
 * @package DS\Component
 */
class TagComponent extends Tag
{
    /**
     * @var TagComponent
     */
    private static $instance = null;

    /**
     * @return TagComponent
     */
    public static function instance()
    {
        if (!self::$instance)
        {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
