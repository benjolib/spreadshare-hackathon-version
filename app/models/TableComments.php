<?php

namespace DS\Model;

use DS\Model\Abstracts\AbstractTableComments;

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
class TableComments
    extends AbstractTableComments
{
    /**
     * @param $tableId
     *
     * @return AbstractTableComments|AbstractTableComments[]|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function getCommentsByTable($tableId)
    {
        return self::find(
            [
                "conditions" => 'tableId = ?0 and isnull(commentId)',
                "bind" => [$tableId],
                'order' => 'createdAt DESC',
            ]
        );
    }
}
