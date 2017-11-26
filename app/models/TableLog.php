<?php

namespace DS\Model;

use DS\Constants\Paging;
use DS\Model\Events\TableLogEvents;

/**
 * TableLog
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 *
 * @method static findFirstById(int $id)
 */
class TableLog
    extends TableLogEvents
{
    /**
     * @param int $tableId
     * @param int $page
     * @param int $limit
     *
     * @return array
     */
    public function getLogs(int $tableId, $page = 0, $limit = Paging::endlessScrollPortions)
    {
        if (!$tableId)
        {
            throw new \InvalidArgumentException('Invalid table id.');
        }
        
        return self::query()
                   ->columns(
                       [
                           TableLog::class . ".id",
                           TableLog::class . ".logType",
                           TableLog::class . ".text",
                           TableLog::class . ".placeholders",
                           TableLog::class . ".createdAt",
                           User::class . ".handle as userHandle",
                           User::class . ".name as userName",
                           User::class . ".image as userImage",
                       ]
                   )
                   ->innerJoin(User::class, TableLog::class . '.userId = ' . User::class . '.id')
                   ->where(TableLog::class . '.tableId = :tableId:', ['tableId' => $tableId])
                   ->limit((int) $limit, (int) Paging::endlessScrollPortions * $page)
                   ->orderBy(TableLog::class . '.id DESC')
                   ->execute()
                   ->toArray() ?: [];
    }
}
