<?php

namespace DS\Model;

use DS\Constants\Paging;
use DS\Model\Events\ChangeRequestsEvents;
use Phalcon\Db;

/**
 * ChangeRequests
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
class ChangeRequests
    extends ChangeRequestsEvents
{
    /**
     * @param int $tableId
     * @param int $limit
     * @param int $page
     *
     * @return array
     */
    public function findChangeRequests(int $tableId, int $limit = 75, int $page = 0): array
    {
        /*
        $query = self::query()
                     ->columns(
                         [
                             self::class . ".id",
                             self::class . ".to",
                             // self::class . ".from", // PHQL has an error with the from column name
                             self::class . ".comment",
                             self::class . ".createdAt",
                             self::class . ".status",
                             User::class . '.handle as userHandle',
                             User::class . '.name as user',
                         ]
                     )
                     ->innerJoin(User::class, self::class . '.userId = ' . User::class . '.id')
                     ->innerJoin(TableCells::class, self::class . '.cellId = ' . TableCells::class . '.id')
                     ->innerJoin(TableRows::class, TableCells::class . '.rowId = ' . TableRows::class . '.id')
                     ->where(TableRows::class . '.tableId = :tableId:', ['tableId' => $tableId])
                     ->limit((int) $limit, (int) Paging::endlessScrollPortions * $page)
                     ->orderBy(self::class . '.id DESC');
        */
        
        $query = $this->readQuery(
            "SELECT `changeRequests`.`id` AS `id`, `changeRequests`.`to` AS `to`, `changeRequests`.`from` AS `from`, `changeRequests`.`comment` AS `comment`, `changeRequests`.`createdAt` AS `createdAt`, `changeRequests`.`status` AS `status`, `user`.`handle` AS `userHandle`, `user`.`name` AS `user` " .
            "FROM `spreadshare`.`changeRequests`  INNER JOIN `spreadshare`.`user` ON `changeRequests`.`userId` = `user`.`id` INNER JOIN `spreadshare`.`tableCells` ON `changeRequests`.`cellId` = `tableCells`.`id` INNER JOIN `spreadshare`.`tableRows` ON `tableCells`.`rowId` = `tableRows`.`id` " .
            "WHERE `tableRows`.`tableId` = :tableId ORDER BY `changeRequests`.`id` DESC LIMIT :limit OFFSET :offset",
            [
                'tableId' => $tableId,
                'limit' => (int) $limit,
                'offset' => (int) Paging::endlessScrollPortions * $page,
            ],
            [
                'limit' => 1,
                'offset' => 1,
            ]
        );
        $query->setFetchMode(Db::FETCH_ASSOC);
        
        return $query->fetchAll() ?: [];
    }
}
