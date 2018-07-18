<?php

namespace DS\Component\View\Functions;

use DS\Model\Tables;
use DS\Model\TableSubscription;
use DS\Model\User;
use Phalcon\Mvc\User\Component;

class StatsHelper extends Component
{
    public static function totalSubscriptions():int
    {
        return TableSubscription::count();
    }

    public static function totalUsers():int
    {
        return User::count();
    }
    public static function usersSubscribers(int $userId):int
    {
        $tableIds = array_column(Tables::findAllByFieldValue('ownerUserId', $userId)->toArray(['id']),'id');

        return TableSubscription::count([
            "tableId IN (".implode(",", $tableIds).")"
        ]);
    }
}