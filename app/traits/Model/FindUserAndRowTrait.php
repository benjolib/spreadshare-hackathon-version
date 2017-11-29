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
trait FindUserAndRowTrait
{
    /**
     * @param int $userId
     * @param int $rowId
     *
     * @return self
     */
    public static function findByUserIdAndRow(int $userId, int $rowId)
    {
        return self::findFirst(
            [
                "conditions" => 'userId = ?0 AND rowId = ?1',
                "bind" => [$userId, $rowId],
                "limit" => 1,
            ]
        );
    }
}
