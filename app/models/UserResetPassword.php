<?php

namespace DS\Model;

use DS\Model\Abstracts\AbstractUserResetPassword;
use DS\Model\Events\UserResetPasswordEvents;

/**
 * UserResetPassword
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 *
 * @method static findFirstById(int $id)
 */
class UserResetPassword
    extends UserResetPasswordEvents
{
    
    /**
     * @param string $code
     * @return UserResetPassword|AbstractUserResetPassword
     */
    public static function findFirstByCode($code)
    {
        return parent::findFirst(
            [
                "conditions" => "code = ?0",
                "limit" => 1,
                "bind" => [$code],
            ]
        );
    }
    
    
}
