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
class HomeLink extends AbstractLink
{
    /**
     * @param string $path
     *
     * @return string
     */
    public static function get(string $path = '/'): string
    {
        return self::prepareUrl($path);
    }
}
