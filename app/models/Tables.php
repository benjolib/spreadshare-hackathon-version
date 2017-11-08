<?php

namespace DS\Model;

use DS\Model\Abstracts\AbstractTables;

/**
 * Comments
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 *
 * @method static findFirstById(int $id)
 */
class Tables
    extends AbstractTables
{
    /**
     * @param $tableId
     *
     * @return AbstractTables|AbstractTables[]|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function getTable($tableId)
    {
        return self::find(
            [
                "conditions" => 'tableId = ?0',
                "bind" => [$tableId],
            ]
        );
    }
}
