<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 25/06/18
 * Time: 10:55
 */

namespace DS\Events\Table;


use DS\Model\DataSource\ChangeRequestStatus;
use DS\Model\DataSource\UserNotificationType;
use DS\Model\RequestAdd;
use DS\Model\Tables;
use DS\Model\User;
use DS\Model\UserNotifications;

class RequestAddUpdated
{
    public static function after(RequestAdd $collab)
    {
        $table = Tables::findFirstById($collab->table_id);
        $status = $collab->status;

        $notif = new UserNotifications;
        if ($status == ChangeRequestStatus::Confirmed) {
            $notif
                ->setNotificationType(UserNotificationType::ChangeRequestedConfirmed)
                ->setText(sprintf("Published your listing on %s", $table->getTitle()));

        } elseif ($status == ChangeRequestStatus::Rejected) {
            $notif
                ->setNotificationType(UserNotificationType::ChangeRequestedRejected)
                ->setText(sprintf("Rejected your listing on %s", $table->getTitle()));

        } else {
            return;
        }
        $notif
            ->setUserId($collab->user_id)
            ->setSourceUserId($table->getOwnerUserId())
            ->setSourceTableId($table->getId())
            ->create();

        //TODO table log
    }
}