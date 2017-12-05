<?php

namespace DS\Events\User;

use DS\Component\Mail\Events\NewUserMail;
use DS\Events\AbstractEvent;
use DS\Model\User;
use DS\Modules\Bernard;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Events\User
 *
 * @todo      Use Phalcons event engine
 */
class UserCreated extends AbstractEvent
{

    /**
     * Issued after a user has been created
     * @param User $user
     */
    public static function after(User $user)
    {

        if ($user->getId())
        {
            // DataSource
            $datasource = [
                'userId' => $user->getId(),
                'email' => $user->getEmail()
            ];

            // Send Table Creation Event To ES Queue
            Bernard::produce('newWallet', $datasource);
            
            // Send new user notification
            NewUserMail::factory(serviceManager()->getDI())->prepare($user)->send();
        }


    }

}
