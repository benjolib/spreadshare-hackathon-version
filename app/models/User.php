<?php

namespace DS\Model;

use DS\Model\Abstracts\AbstractUser;

/**
 * Users
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 *
 * @method static findFirstById(int $id)
 */
class User
    extends AbstractUser
{
    /**
     * @return string
     */
    public function getImage(): string
    {
        return str_replace('http://', '//', parent::getImage());
    }
    
    /**
     * @param        $name
     * @param        $handle
     * @param        $email
     * @param        $description
     * @param        $authUid
     * @param        $profileImage
     * @param        $city
     * @param string $provider
     *
     * @return AbstractUser|User|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function addUserFromAuthService($name, $handle, $email, $description, $authUid, $profileImage, $city, $profileUrl, $provider = 'Facebook')
    {
        $email = $email ? $email : "{$authUid}@" . strtolower($provider) . ".com";
        $user  = User::findFirst(" email='$email' OR authUid='" . $authUid . "' ");
        
        if (!$user)
        {
            $user = new self();
            
            call_user_func([$user, 'set' . $provider . 'Url'], $profileUrl);
            
            $user->setEmail($email)
                 ->setName($name)
                 ->setImage($profileImage)
                 ->setAuthProvider($provider)
                 ->setAuthUid($authUid)
                 ->setHandle($handle)
                 ->setCity($city)
                 ->setDescription($description)
                 ->setCreationDate(time())
                 ->setActive(1)
                 ->setLastLogin(time())
                 ->create();
        }
        else
        {
            call_user_func([$user, 'set' . $provider . 'Url'], $profileUrl);
            
            $user->setEmail($email)
                 ->setName($name)
                 ->setHandle($handle)
                 ->setImage($profileImage)
                 ->setLastLogin(time())
                 ->setActive(1)
                 ->setDescription($description)
                 ->setCity($city)
                 ->save();
        }
        
        return $user;
    }
    
}
