<?php
namespace DS\Cli\Format;

/**
 * The format class controls everything to do with formating
 *
 * @package    CLI
 * @subpackage Format
 */
class Format
{
    /**
     * Instance of the collection
     *
     * @var Object
     */
    protected static $collection;

    /**
     * Set up class
     *
     * @param null $collection
     */
    public function __construct($collection = NULL)
    {
        static::$collection = (!is_null($collection) ? $collection : new FormatCollection);
    }

    /**
     * Adds a format to the collection object
     *
     * @param       $name
     * @param array $details
     */
    public static function addFormat($name, Array $details)
    {
        static::$collection->add($name, $details);
    }

    /**
     * Checks a string for format codes and replaces it with its background/foreground color codes
     *
     * @param $str
     *
     * @return String
     */
    public static function format($str)
    {
        preg_match('/<[A-Za-z0-9]+?>/', $str, $matches);

        foreach ($matches as $match)
        {
            $keyword = str_replace(Array('<', '>'), '', $match);
            $format  = static::$collection->get(strtolower($keyword));
            if (!empty($format))
            {
                $foreground = (!isset($format['foreground']) ? '' : "\33[" . $format['foreground'] . "m");
                $background = (!isset($format['background']) ? '' : "\33[" . $format['background'] . "m");
                $str        = str_replace(
                    Array('<' . $keyword . '>', '</' . $keyword . '>'),
                    Array($foreground . $background, "\33[0m"),
                    $str
                );
            }
        }

        return $str;
    }

}