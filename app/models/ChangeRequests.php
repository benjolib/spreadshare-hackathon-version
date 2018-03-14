<?php

namespace DS\Model;

use DS\Constants\Paging;
use DS\Model\DataSource\ChangeRequestStatus;
use DS\Model\Events\ChangeRequestsEvents;
use DS\Model\Helper\ChangeRequestsFilter;
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
 * @method static ChangeRequests findFirstById(int $id)
 */
class ChangeRequests extends ChangeRequestsEvents
{
    /**
     * @param int                  $tableId
     * @param ChangeRequestsFilter $filter
     * @param int                  $status
     * @param int                  $limit
     * @param int                  $page
     *
     * @return array
     */
    public function findChangeRequests(int $tableId, ChangeRequestsFilter $filter, int $status = ChangeRequestStatus::All, int $limit = 75, int $page = 0): array
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

        $params = [
            'tableId' => $tableId,
            'limit' => (int) $limit,
            'offset' => (int) Paging::endlessScrollPortions * $page,
        ];

        $statusCheck = '';
        if ($status !== ChangeRequestStatus::All) {
            $statusCheck = 'AND `changeRequests`.`status` = :status';
            $params['status'] = $status;
        }

        $showOnlyFilter = '';
        if ($filter->getShowOnly() === ChangeRequestsFilter::ONLY_EDITS) {
            $showOnlyFilter = 'AND `changeRequests`.`to` != ""';
        } elseif ($filter->getShowOnly() === ChangeRequestsFilter::ONLY_DELETES) {
            $showOnlyFilter = 'AND `changeRequests`.`to` = ""';
        } elseif ($filter->getShowOnly() === ChangeRequestsFilter::ONLY_DELETES) {
            $showOnlyFilter = 'AND `changeRequests`.`to` = ""';
        }

        $query = $this->readQuery(
            'SELECT (SELECT `tableRows`.`content` FROM `tableRows` WHERE `tableRows`.`tableId` = :tableId AND `tableRows`.`lineNumber` = 1 LIMIT 1) as `row`, (SELECT `tableColumns`.`title` FROM `tableColumns` WHERE `tableColumns`.`id` = `tableCells`.`columnId` LIMIT 1) as `column`, `changeRequests`.`id` AS `id`, `changeRequests`.`to` AS `to`, `changeRequests`.`from` AS `from`, `changeRequests`.`comment` AS `comment`, `changeRequests`.`createdAt` AS `createdAt`, `changeRequests`.`status` AS `status`, `user`.`handle` AS `userHandle`, `user`.`image` AS `userImage`, `user`.`name` AS `user` ' .
            'FROM `spreadshare`.`changeRequests`  INNER JOIN `spreadshare`.`user` ON `changeRequests`.`userId` = `user`.`id` INNER JOIN `spreadshare`.`tableCells` ON `changeRequests`.`cellId` = `tableCells`.`id` INNER JOIN `spreadshare`.`tableRows` ON `tableCells`.`rowId` = `tableRows`.`id` ' .
            "WHERE `tableRows`.`tableId` = :tableId $statusCheck $showOnlyFilter ORDER BY `changeRequests`.`id` DESC LIMIT :limit OFFSET :offset",
            $params,
            [
                'limit' => 1,
                'offset' => 1,
            ]
        );
        $query->setFetchMode(Db::FETCH_ASSOC);

        return $query->fetchAll() ?: [];
    }

    public function getChanges()
    {
    }
}
