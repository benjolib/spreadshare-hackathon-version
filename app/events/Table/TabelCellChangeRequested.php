<?php

namespace DS\Events\Table;

use DS\Events\AbstractEvent;
use DS\Model\DataSource\TableLogType;
use DS\Model\DataSource\UserNotificationType;
use DS\Model\TableLog;
use DS\Model\Tables;
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
class TabelCellChangeRequested extends AbstractEvent
{
    
    /**
     * Issued after the rows of a table has been changed.
     *
     * E.g. a table has been imported from CSV or a change request was accepted.
     *
     * @param int    $userId     User id that triggered the change
     * @param int    $cellId     Cell id
     * @param int    $tableId    Table id
     * @param int    $changeId   changeRequests.id
     * @param string $changeFrom Cell content changed from
     * @param string $changeTo   Cell content changed to
     *
     */
    public static function after(int $userId, int $cellId, int $tableId, int $changeId, string $changeFrom, string $changeTo)
    {
        $userNotification = new UserNotifications();
        
        $table = Tables::get($tableId);
        $userNotification
            ->setUserId($table->getOwnerUserId())
            ->setSourceTableId($tableId)
            ->setPlaceholders(
                json_encode(
                    [
                        User::get($userId)->getName(),
                        $table->getTitle(),
                    ]
                )
            )
            ->setSourceUserId($userId)
            ->setNotificationType(UserNotificationType::ChangeRequested)
            ->setText(sprintf('requested a change for your table %s', $table->getTitle()))
            ->create();
        
        $tableLog = new TableLog();
        $tableLog
            ->setUserId($userId)
            ->setTableId($tableId)
            ->setLogType(TableLogType::ContributionCellChangeRequested)
            ->setText('requested a cell change.')
            ->setPlaceholders(
                json_encode(
                    [
                        $changeId,
                        $cellId,
                        $changeId,
                        $changeFrom,
                        $changeTo,
                    ]
                )
            )
            ->create();
    }
    
}