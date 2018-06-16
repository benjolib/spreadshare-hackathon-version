<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 16/06/18
 * Time: 10:42
 */

namespace DS\Component\View\Functions;


use DS\Component\ServiceManager;
use DS\Model\UserFollower;
use Phalcon\Mvc\User\Component;

class Following extends Component
{
    public static function amIFollowing($userId)
    {
        $s = new self;
        $serviceManager = ServiceManager::instance($s->getDI());
        $authId = $serviceManager->getAuth()->getUserid();
        return !empty(UserFollower::findFollower($userId, $authId));
    }

}