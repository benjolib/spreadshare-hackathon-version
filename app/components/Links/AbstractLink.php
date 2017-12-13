<?php

namespace DS\Component\Links;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component\Time
 */
abstract class AbstractLink
{
    /**
     * @return \Phalcon\Di
     */
    protected static function getDi()
    {
        return di();
    }
    
    /**
     * @param string $path
     *
     * @return string
     */
    public static function prepareUrl(string $path = '/'): string
    {
        return sprintf(request()->getScheme() . '://%s%s', self::getDi()->get('config')->get('domain'), $path);
    }
}
