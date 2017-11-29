<?php

namespace DS\Events\Table;

use DS\Events\AbstractEvent;
use DS\Model\DataSource\DefaultTokenDistribution;
use DS\Model\DataSource\TableLogType;
use DS\Model\DataSource\TokenDistributionType;
use DS\Model\DataSource\UserNotificationType;
use DS\Model\TableLog;
use DS\Model\Tables;
use DS\Model\TableTokens;
use DS\Model\User;
use DS\Model\UserNotifications;

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
class TableUpvoted extends AbstractEvent
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
            ->setNotificationType(UserNotificationType::TableUpvoted)
            ->setText(sprintf('upvoted your table %s', $table->getTitle()))
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
            ->setLogType(TableLogType::Subscribed)
            ->setText('upvoted this table.')
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
         * Give a token to this user for this upvote
         */
        $tableToken = new TableTokens();
        $tableToken->setUserId($table->getOwnerUserId()) // Its important to credit the owner of the table not the user
                   ->setTokensEarned(DefaultTokenDistribution::PerVote)
                   ->setOwnership(0)
                   ->setTableId($tableId)
                   ->setType(TokenDistributionType::Upvote)
                   ->create();
    }
    
}