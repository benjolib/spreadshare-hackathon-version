<?php

namespace DS\Model;

use DS\Model\Events\UserEvents;

/**
 * User
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
class User
    extends UserEvents
{
    /**
     * @param array $param
     * @param int   $page
     * @param int   $limit
     *
     * @return array
     */
    /*
    public function findCustom($param = [], $page = 0, $limit = Paging::endlessScrollPortions)
    {
        if (count($param))
        {
            return self::query()
                       ->columns(
                           [
                               User::class . ".id",
                           ]
                       )
                //->leftJoin(User::class, User::class . '.profileId = ' . Profile::class . '.id')
                //->inWhere(Profile::class . '.id', $param)
                       ->limit((int) $limit, (int) Paging::endlessScrollPortions * $page)
                //->orderBy(sprintf('FIELD (id,%s)', implode(',', $param)))
                       ->execute()
                       ->toArray() ?: [];
        }
        
        return [];
    }
    */
    
    /**
     * @return string
     */
    public function getImage(): string
    {
        return str_replace('http://', '//', parent::getImage());
    }
    
    /**
     * Get username by email address or username
     *
     * @param $usernameOrEmail
     *
     * @return Abstracts\AbstractUser|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirstByUsernameOrEmail($usernameOrEmail)
    {
        return parent::findFirst(
            [
                "conditions" => "handle = ?0 OR email = ?1",
                "limit" => 1,
                "bind" => [$usernameOrEmail, $usernameOrEmail],
            ]
        );
    }
    
    /**
     * @param string $name
     * @param string $email
     * @param string $handle
     * @param string $unhashedPassword
     *
     * @return User
     */
    public static function addUserFromSignup($name, $handle, $email, $unhashedPassword)
    {
        $user = new User();
        $user->setName($name)
             ->setHandle($handle)
             ->setEmail($email)
             ->setSecuritySalt(serviceManager()->getSecurity()->hash($unhashedPassword))
             ->create();
        
        return $user;
    }
    
    /**
     * @param        $name
     * @param        $handle
     * @param        $email
     * @param        $description
     * @param        $tagline
     * @param        $authUid
     * @param        $profileImage
     * @param        $city
     * @param string $provider
     *
     * @return User|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function addUserFromAuthService($name, $handle, $email, $description, $tagline, $authUid, $profileImage, $city, $provider = 'Facebook')
    {
        $email = $email ? $email : "{$authUid}@" . strtolower($provider) . ".com";
        $user  = User::findFirst(" email='$email' OR authUid='" . $authUid . "' ");
        
        if (!$user)
        {
            $user = new self();
            
            $user->setEmail($email)
                 ->setName($name)
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
        else
        {
            $user->setEmail($email)
                 ->setName($name)
                 ->setHandle($handle)
                 ->setImage($profileImage)
                 ->setLastLogin(time())
                 ->setTagline($tagline)
                 ->setDescription($description)
                 ->setLocation($city)
                 ->save();
        }
        
        return $user;
    }
}
