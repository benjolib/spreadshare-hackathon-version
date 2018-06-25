<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 25/06/18
 * Time: 10:55
 */

namespace DS\Events\Table;


use DS\Model\DataSource\UserNotificationType;
use DS\Model\RequestAdd;
use DS\Model\RequestDelete;
use DS\Model\TableRows;
use DS\Model\Tables;
use DS\Model\User;
use DS\Model\UserNotifications;

class RequestDeleteCreated
{
    public static function after(RequestDelete $collab)
    {
        $row = TableRows::findFirstById($collab->row_id);
        $user = User::findFirstById($collab->user_id);
        $table = Tables::findFirstById($row->getTableId());

        $notif = new UserNotifications;
        $notif
            ->setUserId($table->getOwnerUserId())
            ->setSourceUserId($user->getId())
            ->setSourceTableId($table->getId())
            ->setNotificationType(UserNotificationType::ChangeRequested)
            ->setText(sprintf("Asked to remove a listing on %s", $table->getTitle()))
            ->create();

        //TODO table log
    }
}