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
    public function getTableUsers(int $tableId, bool $upvoters = false, bool $subscribers = false, bool $contributors = false, bool $admins = false): array
    {
        $columns = [
            User::class . ".id",
            User::class . ".image",
            User::class . ".name",
            User::class . ".handle",
            User::class . ".tagline",
            User::class . ".location",
            "(SELECT " . UserFollower::class . ".id FROM " . UserFollower::class . " WHERE " . UserFollower::class . ".userId = " . User::class . ".id AND " . UserFollower::class . ".followedByUserId = " .
            serviceManager()->getAuth()->getUserId() . ") as following",
        ];
        
        $query = self::query()
                     ->where(Tables::class . '.id = :tableId:', ['tableId' => $tableId])
                     ->groupBy(User::class . '.id')
                     ->limit(Paging::endlessScrollPortions);
        
        if ($subscribers)
        {
            $query->innerJoin(TableSubscription::class, TableSubscription::class . '.userId = ' . User::class . '.id');
            $query->innerJoin(Tables::class, TableSubscription::class . '.tableId = ' . Tables::class . '.id');
            $columns[] = TableSubscription::class . '.createdAt as subscribedAt';
        }
        else
        {
            $query->leftJoin(TableSubscription::class, TableSubscription::class . '.userId = ' . User::class . '.id');
        }
        
        if ($upvoters)
        {
            $query->innerJoin(TableVotes::class, TableVotes::class . '.userId = ' . User::class . '.id');
            $query->innerJoin(Tables::class, TableVotes::class . '.tableId = ' . Tables::class . '.id');
        }
        else
        {
            $query->leftJoin(TableVotes::class, TableVotes::class . '.userId = ' . User::class . '.id');
        }
        
        if ($contributors)
        {
            $query->innerJoin(TableCells::class, TableCells::class . '.userId = ' . User::class . '.id')
                  ->innerJoin(TableRows::class, TableCells::class . '.rowId = ' . TableRows::class . '.id')
                  ->innerJoin(Tables::class, TableRows::class . '.tableId = ' . Tables::class . '.id');
        }
        else
        {
            $query->leftJoin(TableCells::class, TableCells::class . '.userId = ' . User::class . '.id');
        }
        
        if ($admins)
        {
            $query->innerJoin(Tables::class, Tables::class . '.ownerUserId = ' . User::class . '.id');
        }
        
        return $query->columns($columns)->execute()->toArray();
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
     * @param        $website
     * @param string $provider
     *
     * @return User|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function addUserFromAuthService($name, $handle, $email, $description, $tagline, $authUid, $profileImage, $city, $website = '', $provider = 'Facebook')
    {
        $email = $email ? $email : "{$authUid}@" . strtolower($provider) . ".com";
        $user  = User::findFirst(
            [
                "conditions" => " email = ?0 OR authUid = ?1",
                "bind" => [$email, $authUid],
            ]
        );
        
        $urlPattern = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
        
        if (!$user)
        {
            $userHandle = User::findByFieldValue('handle', $handle);
            // Add Auth UserId to handle if a user with the same handle already exists
            if ($userHandle)
            {
                $handle .= '-' . $authUid;
            }
            
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
                 ->setLastLogin(time());
            
            if ($website && preg_match($urlPattern, $website))
            {
                $user->setWebsite($website);
            }
            
            $user->create();
        }
        else
        {
            $user->setEmail($email)
                 ->setName($name)
                 ->setImage($profileImage)
                 ->setAuthProvider($provider)
                 ->setAuthUid($authUid)
                 ->setHandle($handle)
                 ->setLocation($city)
                 ->setDescription($description)
                 ->setTagline($tagline);
            
            if ($website && preg_match($urlPattern, $website))
            {
                $user->setWebsite($website);
            }
            
            $user->save();
        }
        
        return $user;
    }
}
