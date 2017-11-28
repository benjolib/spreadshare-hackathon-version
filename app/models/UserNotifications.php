<?php

namespace DS\Model;

use DS\Constants\Paging;
use DS\Model\Events\UserNotificationsEvents;

/**
 * UserNotifications
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
class UserNotifications
    extends UserNotificationsEvents
{
    /**
     * @param int $userId
     * @param int $page
     * @param int $limit
     *
     * @return array
     */
    public function findNotifications(int $userId, $type = null, $page = 0, $limit = Paging::endlessScrollPortions): array
    {
        if ($userId > 0)
        {
            $query = self::query()
                         ->columns(
                             [
                                 self::class . ".id",
                                 self::class . ".notificationType",
                                 self::class . ".text",
                                 self::class . ".placeholders",
                                 self::class . ".createdAt",
                                 User::class . ".handle as userHandle",
                                 User::class . ".name as userName",
                                 User::class . ".image as userImage",
                             ]
                         )
                         ->leftJoin(User::class, self::class . '.sourceUserId = ' . User::class . '.id')
                         ->leftJoin(Tables::class, self::class . '.sourceTableId = ' . Tables::class . '.id')
                         ->where(self::class . '.userId = :userId:', ['userId' => $userId])
                         ->limit((int) $limit, (int) Paging::endlessScrollPortions * $page)
                         ->orderBy(UserNotifications::class . '.id DESC');
            
            if ($type)
            {
                $query->where(self::class . '.notificationType = :type', ['type' => $type]);
            }
            
            return $query
                ->execute()
                ->toArray() ?: [];
        }
        
        return [];
    }
}
