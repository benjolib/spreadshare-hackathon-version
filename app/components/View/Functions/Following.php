<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 16/06/18
 * Time: 10:42
 */

namespace DS\Component\View\Functions;


use DS\Component\ServiceManager;
use DS\Model\TableSubscription;
use DS\Model\UserFollower;
use Phalcon\Mvc\User\Component;

class Following extends Component
{
    private static function getAuthenticatedUserId():int
    {
        $s = new self;
        $serviceManager = ServiceManager::instance($s->getDI());
        return $serviceManager->getAuth()->getUserid();

    }

    public static function amIFollowing($userId)
    {
        $authId = self::getAuthenticatedUserId();
        return !empty(UserFollower::findFollower($userId, $authId));
    }

    public static function amISubscribed($streamId)
    {
        $authId = self::getAuthenticatedUserId();
        return !empty(TableSubscription::findSubscription($authId, $streamId));
    }
}