<?php

namespace DS\Model;

use DS\Component\Mail\Events\SignupMail;
use DS\Constants\Paging;
use DS\Model\Events\UserEvents;
use DS\Model\Helper\RandomUserImage;

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
 * @method static User findFirstById(int $id)
 */
class User
    extends UserEvents
{
    /**
     * @return string
     */
    public function getImage(): string
    {
        return str_replace('http://', '//', parent::getImage());
    }
    
    /**
     * @param int  $tableId
     * @param bool $upvoters
     * @param bool $subscribers
     * @param bool $contributors
     *
     * @return array
     */
    public function getTableUsers(int $tableId, bool $upvoters = false, bool $subscribers = false, bool $contributors = false): array
    {
        $query = self::query()
                     ->columns(
                         [
                             User::class . ".id",
                             User::class . ".image",
                             User::class . ".name",
                             User::class . ".handle",
                             User::class . ".tagline",
                             User::class . ".location",
                             "(SELECT " . UserFollower::class . ".id FROM " . UserFollower::class . " WHERE " . UserFollower::class . ".userId = " . User::class . ".id AND " . UserFollower::class . ".followedByUserId = " .
                             serviceManager()->getAuth()->getUserId() . ") as following",
                         ]
                     )
                     ->leftJoin(Tables::class, Tables::class . '.ownerUserId = ' . User::class . '.id')
                     ->leftJoin(TableVotes::class, TableVotes::class . '.userId = ' . User::class . '.id')
                     ->leftJoin(TableSubscription::class, TableSubscription::class . '.userId = ' . User::class . '.id')
                     ->leftJoin(TableCells::class, TableCells::class . '.userId = ' . User::class . '.id')
                     ->groupBy(User::class . '.id')
                     ->where(Tables::class . '.id = :tableId:', ['tableId' => $tableId])
                     ->limit(Paging::endlessScrollPortions);
        
        if ($upvoters)
        {
            $query->andWhere('!ISNULL(' . TableVotes::class . '.userId)');
        }
        
        if ($subscribers)
        {
            $query->andWhere('!ISNULL(' . TableSubscription::class . '.userId)');
        }
        
        if ($contributors)
        {
            $query->andWhere('!ISNULL(' . TableCells::class . '.userId)');
        }
        
        return $query->execute()->toArray();
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
     * Save user credentials. Leave password blank to not update.
     *
     * @param string $email
     * @param string $unhashedPassword
     *
     * @return $this
     */
    public function saveCredentials(string $email, string $unhashedPassword)
    {
        if ($unhashedPassword)
        {
            $this->setSecuritySalt(serviceManager()->getSecurity()->hash($unhashedPassword));
        }
        
        $this->setEmail($email)
             ->save();
        
        return $this;
    }
    
    /**
     * @param string $name
     * @param string $email
     * @param string $handle
     * @param string $unhashedPassword
     *
     * @return User
     */
    public function addUserFromSignup($name, $handle, $email, $unhashedPassword)
    {
        $user = new User();
        $user->setName($name)
             ->setHandle($handle)
             ->setEmail($email)
             ->setImage(RandomUserImage::get())
             ->setSecuritySalt(serviceManager()->getSecurity()->hash($unhashedPassword))
             ->create();
        
        // Send mail
        SignupMail::factory($this->getDI())
                  ->prepare($user)
                  ->send();
        
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
