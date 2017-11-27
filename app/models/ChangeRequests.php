<?php

namespace DS\Model;

use DS\Constants\Paging;
use DS\Model\Events\ChangeRequestsEvents;

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
    public static function findChangeRequests(int $tableId, int $limit = 75, int $page = 0): array
    {
        $query = self::query()
                            ->columns(
                                [
                                    self::class . ".id",
                                    self::class . ".from",
                                    self::class . ".to",
                                    self::class . ".comment",
                                    self::class . ".status",
                                    self::class . ".createdAt",
                                    self::class . ".cellId",
                                    User::class . '.handle',
                                    User::class . '.name',
                                ]
                            )
                            ->innerJoin(User::class, self::class . '.userId = ' . User::class . '.id')
                            ->where(self::class . '.tableId = :tableId:', ['tableId' => $tableId])
                            ->limit((int) $limit, (int) Paging::endlessScrollPortions * $page)
                            ->orderBy(self::class . '.id DESC');

               return $query->execute()->toArray() ?: [];
    }
}
