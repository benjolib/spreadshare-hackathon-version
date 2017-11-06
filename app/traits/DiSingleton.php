<?php
namespace DS\Traits;

/**
 * Spreadshare
 *
 * Singleton trait. Just do "use Singleton;" and you're ready to go.
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component\Provider
 */
trait DiSingleton
{
    // Get di injecttion functions as well as __wakup and __clone from Singelton
    use DiInjection, Singleton;
    
    /**
     * @var Singleton
     */
    protected static $instance = NULL;
    
    /**
     * Return singleton instance of current class
     *
     * @param \Phalcon\DiInterface $dependencyInjector
     *
     * @return static
     */
    public static function instance(\Phalcon\DiInterface $dependencyInjector)
    {
        $l_class = get_called_class();
        if (!isset(static::$instance[$l_class]) || is_null(static::$instance[$l_class]))
        {
            static::$instance[$l_class] = new $l_class($dependencyInjector);
        }

        return static::$instance[$l_class];
    }
}
