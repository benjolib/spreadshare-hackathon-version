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
    public static function userSubscribers(int $userId):int
    {
        $tableIds = array_column(Tables::findAllByFieldValue('ownerUserId', $userId)->toArray(['id']),'id');

        if(empty($tableIds)) {
            return 0;
        }

        return TableSubscription::count([
            "tableId IN (".implode(",", $tableIds).")"
        ]);
    }
    public static function round(float $number):float
    {
        return round($number,2);
    }
}