<?php

namespace DS\Traits\Model;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Interfaces
 */
trait FindUserAndTableTrait
{
    /**
     * @param int $userId
     * @param int $tableId
     *
     * @return self
     */
    public static function findByUserIdAndTable(int $userId, int $tableId)
    {
        return self::findFirst(
            [
                "conditions" => 'tableId = ?0 AND userId = ?1',
                "bind" => [$tableId, $userId],
            ]
        );
    }
}
