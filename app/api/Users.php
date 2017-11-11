<?php

namespace DS\Api;

use DS\Model\User;

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
class Users
    extends BaseApi
{
    
    /**
     * @param string $name
     * @param string $password
     * @param string $handle
     * @param string $email
     * @param string $description
     * @param string $tagline
     * @param string $authUid
     * @param string $profileImage
     * @param string $city
     * @param string $provider
     */
    public static function createUser($name, $password, $handle, $email, $description, $tagline, $authUid, $profileImage, $city, $provider = 'Facebook')
    {
        $email = $email ? $email : "{$authUid}@" . strtolower($provider) . ".com";
        $user  = User::findFirst(" email='$email' OR authUid='" . $authUid . "' ");
        
        if (!$user)
        {
            $user = new User();
            
            $user->setEmail($email)
                 ->setName($name)
                 ->setSecuritySalt(serviceManager()->getSecurity()->hash($password))
                 ->setImage($profileImage)
                 ->setAuthProvider($provider)
                 ->setAuthUid($authUid)
                 ->setHandle($handle)
                 ->setLocation($city)
                 ->setDescription($description)
                 ->setTagline($tagline)
                 ->setLastLogin(time())
                 ->create();
        }
        
        return $user;
    }
}