<?php

namespace DS\Api;

use DS\Application;
use DS\Exceptions\GeneralUserException;
use DS\Model\DataSource\UserStatus;
use DS\Model\User;
use Phalcon\Logger;

/**
 * Spreadshare
 *
 * General Users Api
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
class Login
    extends BaseApi
{
    
    /**
     * General login api
     *
     * This methods creates a user session.
     */
    public function login($usernameOrEmail, $password)
    {
        // Find user by username or email@
        $user = User::findFirstByUsernameOrEmail($usernameOrEmail);
        if ($user)
        {
            if ($user->getStatus() == UserStatus::Confirmed)
            {
                $serviceManager = $this->serviceManager;
                
                // Check for hash validity
                if ($serviceManager->getSecurity()->checkHash($password, $user->getSecuritySalt()))
                {
                    try
                    {
                        $auth = $serviceManager->getAuth();
                        
                        // Store session, update last login date of user and set a cookie
                        $token =
                            $auth->storeSession($user)
                                 ->updateLastLogin()
                                 ->getSessionToken();
                        
                        $serviceManager->getCookies()->set('sessToken', $token)->send();
                    }
                    catch (\Exception $e)
                    {
                        Application::instance()->log($e->getMessage(), Logger::CRITICAL);
                    }
                }
                else
                {
                    throw new GeneralUserException('Invalid username or password.');
                }
            }
            else
            {
                throw new GeneralUserException('Your user is not confirmed, yet. Please check your email!');
            }
        }
        
        return $user;
    }
}