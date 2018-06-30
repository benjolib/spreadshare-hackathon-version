<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 30/06/18
 * Time: 9:22
 */

namespace DS\Component\View\Functions;


use DS\Model\User;
use Phalcon\Mvc\User\Component;

class UserHelper extends Component
{
    public static function handleFromId(int $userId):string
    {
        $user = User::get($userId);
        return $user->getHandle();
    }
}