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
class TableCommentsLink extends AbstractLink
{
    /**
     * @param string $tableId
     *
     * @return string
     */
    public static function get(string $tableId): string
    {
        return self::prepareUrl('/table/' . $tableId . '/about');
    }
}
