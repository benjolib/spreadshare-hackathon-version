<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 30/06/18
 * Time: 9:22
 */

namespace DS\Component\View\Functions;


use DS\Model\DataSource\ChangeRequestStatus;
use DS\Model\RequestAdd;
use DS\Model\TableVotes;
use DS\Model\TableRowVotes;
use DS\Model\User;
use Phalcon\Mvc\User\Component;

class UserHelper extends Component
{
    public static function handleFromId(int $userId):string
    {
        return User::get($userId)->getHandle();
    }

    public static function userHasVotedTable(int $userId, int $tableId):bool
    {
        return !empty(TableVotes::findByUserIdAndTable($userId, $tableId));
    }
    public static function userHasVotedRow(int $rowId, int $userId):bool
    {
        return !empty(TableRowVotes::votedForRow($rowId, $userId));
    }

    public static function pendingReceived(int $userId):int
    {
        return RequestAdd::count(['status'=>ChangeRequestStatus::AwaitingApproval]);
    }
}