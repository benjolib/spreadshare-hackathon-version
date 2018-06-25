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
use DS\Model\Tables;
use DS\Model\User;
use DS\Model\UserNotifications;

class RequestAddCreated
{
    public static function after(RequestAdd $collab)
    {
        $user = User::findFirstById($collab->user_id);
        $table = Tables::findFirstById($collab->table_id);

        $notif = new UserNotifications;
        $notif
            ->setUserId($table->getOwnerUserId())
            ->setSourceUserId($user->getId())
            ->setSourceTableId($table->getId())
            ->setNotificationType(UserNotificationType::ChangeRequested)
            ->setText(sprintf("Collaborated on %s", $table->getTitle()))
            ->create();

        //TODO table log
    }
}