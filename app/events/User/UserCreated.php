<?php

namespace DS\Events\User;

use DS\Application;
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
     *
     * @param User $user
     */
    public static function after(User $user)
    {
        
        if ($user->getId())
        {
            // DataSource
            $datasource = [
                'userId' => $user->getId(),
                'email' => $user->getEmail(),
            ];
            
            // Send Table Creation Event To ES Queue
            Bernard::produce('newWallet', $datasource);
            
            // Send new user notification
            try
            {
                serviceManager()->getSlack()->to(Application::instance()->getConfig()['slack']['users-channel'])->send(
                    sprintf('New User: %s, %s (http://%s/user/%s)', $user->getName(), $user->getEmail(), Application::instance()->getConfig()['domain'], $user->getHandle())
                );
            } catch (\Exception $e)
            {
                // not that important..
            }
        }
        
    }
    
}
