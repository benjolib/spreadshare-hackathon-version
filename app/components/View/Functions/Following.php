<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 16/06/18
 * Time: 10:42
 */

namespace DS\Component\View\Functions;


use DS\Model\UserFollower;
use Phalcon\Mvc\User\Component;

class Following extends Component
{
    public static function amIFollowing($I, $userId)
    {
        return !empty(UserFollower::findFollower($userId, $I));
    }

}