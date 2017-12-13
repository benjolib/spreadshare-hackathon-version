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
class TableUsersLink extends AbstractLink
{
    /**
     * @param string $userHandle
     *
     * @return string
     */
    public static function get(string $tableId): string
    {
        return self::prepareUrl('/table/' . $tableId . '/users/subscribers');
    }
}
