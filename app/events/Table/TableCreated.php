<?php

namespace DS\Events\Table;

use DS\Events\AbstractEvent;
use DS\Model\DataSource\DefaultTokenDistribution;
use DS\Model\DataSource\TableContributionType;
use DS\Model\DataSource\TableLogType;
use DS\Model\DataSource\TokenDistributionType;
use DS\Model\DataSource\UserNotificationType;
use DS\Model\TableContributions;
use DS\Model\TableLog;
use DS\Model\Tables;
use DS\Model\TableTokens;
use DS\Model\UserFollower;
use DS\Model\UserNotifications;
use DS\Modules\Bernard;

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
 *
 * @todo      Use Phalcons event engine
 */
class TableCreated extends AbstractEvent
{

    /**
     * Issued after a table has been created
     *
     * @param int    $userId
     * @param Tables $table
     */
    public static function after(int $userId, Tables $table)
    {

        if ($table->getId())
        {
            // DataSource
            $datasource = [
                'isUpdated' => false,
                'tableId' => $table->getId(),
                'tableTitle' => $table->getTitle(),
                'tableTagline' => $table->getTagline(),
            ];

            // Send Table Creation Event To ES Queue
//            Bernard::produce('touchTable', $datasource);
        }

        // Initialize table log with a table created entry
        $tableLog = new TableLog();
        $tableLog->setTableId($table->getId())
                 ->setLogType(TableLogType::Created)
                 ->setUserId($userId)
                 ->setPlaceholders('')
                 ->setText('created this table.')
                 ->create();

        $tableContributions = new TableContributions();
        $tableContributions->setTableOwnership(100)
                           ->setUserId($table->getOwnerUserId())
                           ->setType(TableContributionType::Create)
                           ->create();

        // Initialize table tokens for user
        $tableTokens = new TableTokens();
        $tableTokens->setUserId($table->getOwnerUserId())
                    ->setTableId($table->getId())
                    ->setType(TokenDistributionType::Owner)
                    ->setTokensEarned(DefaultTokenDistribution::TableCreation)
                    ->create();

        //Create notifications for followers
        /** @var UserFollower[] $followers */
        $followers = UserFollower::findAllByFieldValue('userId', $userId);
        foreach ($followers as $follower) {
            $notif = new UserNotifications;
            $notif
                ->setUserId($follower->getFollowedByUserId())
                ->setSourceUserId($userId)
                ->setSourceTableId($table->getId())
                ->setNotificationType(UserNotificationType::TableCreated)
                ->setText(sprintf('Started curating %s', $table->getTitle()))
                ->create();

        }


    }

}
