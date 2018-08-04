<?php

namespace DS\Events\User;

use DS\Component\ServiceManager;
use DS\Events\AbstractEvent;
use DS\Model\DataSource\TableLogType;
use DS\Model\TableLog;
use DS\Model\TableStats;
use DS\Model\User;

class UserTableUnsubscribed extends AbstractEvent
{
    
    public static function after(int $userId, int $tableId)
    {
        $user  = User::findFirstById($userId);
        self::changeTableLog($userId, $tableId, $user);
        self::changeTableStats($tableId);
        self::unsubscribeFromEmailNotifications($userId, $tableId);
    }

    private static function unsubscribeFromEmailNotifications(int $userId, int $tableId)
    {
        ServiceManager::instance(self::getDI())
            ->getSubscriptionsService()
            ->unsubscribeFromEmailNotifications($userId, $tableId);
    }

    public static function changeTableLog(int $userId, int $tableId, User $user)
    {
        $tableLog = new TableLog();
        $tableLog
            ->setUserId($userId)
            ->setTableId($tableId)
            ->setLogType(TableLogType::Unsubscribed)
            ->setText('unsubscribed this table.')
            ->setPlaceholders(
                json_encode(
                    [
                        $user->getId(),
                        $user->getName(),
                    ]
                )
            )
            ->create();
    }

    public static function changeTableStats(int $tableId)
    {
        $tableStats = TableStats::findByFieldValue('tableId', $tableId);
        if (!$tableStats) {
            $tableStats = new TableStats;
        }
        $tableStats->setSubscriberCount($tableStats->getSubscriberCount() - 1)->save();
    }

}