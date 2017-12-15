<?php

namespace DS\Events\Table;

use DS\Events\AbstractEvent;
use DS\Model\DataSource\TableLogType;
use DS\Model\DataSource\UserNotificationType;
use DS\Model\TableLog;
use DS\Model\Tables;
use DS\Model\TableTokens;
use DS\Model\User;
use DS\Model\UserNotifications;
use DS\Model\UserStats;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Events\Table
 */
class TableDownvoted extends AbstractEvent
{
    
    /**
     * Issued after a table has been upvoted
     *
     * @param int $userId
     * @param int $tableId
     */
    public static function after(int $userId, int $tableId)
    {
        $user  = User::get($userId);
        $table = Tables::get($tableId);
        
        $userNotification = new UserNotifications();
        $userNotification
            ->setUserId($table->getOwnerUserId())
            ->setSourceUserId($userId)
            ->setSourceTableId($tableId)
            ->setNotificationType(UserNotificationType::TableDownvoted)
            ->setText(sprintf('revoked his vote for your table %s', $table->getTitle()))
            ->setPlaceholders(
                json_encode(
                    [
                        $user->getName(),
                        $table->getTitle(),
                    ]
                )
            )
            ->create();
        
        $tableLog = new TableLog();
        $tableLog
            ->setUserId($userId)
            ->setTableId($tableId)
            ->setLogType(TableLogType::Downvoted)
            ->setText('downvoted this table.')
            ->setPlaceholders(
                json_encode(
                    [
                        $user->getId(),
                        $user->getName(),
                    ]
                )
            )
            ->create();
        
        /**
         * Delete owners's token on downvote
         */
        $tableToken = TableTokens::findByUserIdAndTable($table->getOwnerUserId(), $tableId);
        if ($tableToken)
        {
            $tableToken->delete();
        }
        
        UserStats::decrement($table->getOwnerUserId(), 'upvotes');
    }
    
}