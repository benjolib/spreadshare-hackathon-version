<?php

namespace DS\Events\Table;

use DS\Events\AbstractEvent;
use DS\Model\DataSource\DefaultTokenDistribution;
use DS\Model\DataSource\TokenDistributionType;
use DS\Model\DataSource\UserNotificationType;
use DS\Model\TableRows;
use DS\Model\Tables;
use DS\Model\TableTokens;
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
class TableRowUpvoted extends AbstractEvent
{
    
    /**
     * @param int       $userId
     * @param TableRows $row
     */
    public static function after(int $userId, TableRows $row)
    {
        $table = Tables::get($row->getTableId());
        $notif = new UserNotifications;
        $notif
            ->setUserId($table->getOwnerUserId())
            ->setSourceUserId($userId)
            ->setSourceTableId($table->getId())
            ->setNotificationType(UserNotificationType::TableUpvoted)
            ->setText(sprintf('Spreaded a listing on %s', $table->getTitle()))
            ->create();
        
        // Row-votes shouldnt creat tokens!
        /**
         * Give a token to this user for this upvote
        $tableToken = new TableTokens();
        $tableToken->setUserId($table->getOwnerUserId())
            ->setTokensEarned(DefaultTokenDistribution::PerVote)
            ->setOwnership(0)
            ->setTableId($row->getTableId())
            ->setRowId($row->getId())
            ->setType(TokenDistributionType::Upvote)
            ->create();
         *  */
    }
    
}