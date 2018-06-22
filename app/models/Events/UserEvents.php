<?php

namespace DS\Model\Events;

use DS\Events\User\UserCreated;
use DS\Exceptions\UserValidationException;
use DS\Model\Abstracts\AbstractUser;
use DS\Model\DataSource\UserRoles;
use DS\Model\DataSource\UserStatus;
use DS\Model\User;
use DS\Model\UserStats;
use DS\Model\Wallet;
use Phalcon\Mvc\Model;

/**
 * Events for model User
 *
 * @see       https://docs.phalconphp.com/ar/3.2/db-models-events
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 */
abstract class UserEvents
    extends AbstractUser
{
    
    private $emailMinimumLength = 5;
    
    /**
     * Before create
     */
    public function beforeCreate()
    {
        $this->emailConfirmationToken = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(24)));
        
        $this->setConfirmed(0);
        
        if (!$this->getStatus())
        {
            $this->setStatus(UserStatus::Unconfirmed);
        }
    }
    
    /**
     * After create
     */
    public function afterCreate()
    {
        
        (new Wallet())->setUserId($this->getId())
                      ->setTokens(0)
                      ->setContractAddress('')
                      ->setData('')
                      ->create();
        
        // Create users wallet using queue
        if ($this instanceof User)
        {
            UserCreated::after($this);
        }
        
        (new UserStats())->setUserId($this->getId())
                         ->create();
    }
    
    /**
     * @return bool
     */
    public function beforeValidationOnCreate()
    {
        parent::beforeValidationOnCreate();
        
        // Check if user with hande or email address already exists
        if (($user = self::findFirstByHandleOrEmail($this->getHandle(), $this->getEmail())))
        {
            if ($user->getHandle() == $this->getHandle())
            {
                throw new UserValidationException(
                    'A user with this username already exists.',
                    'handle',
                    $this->getHandle()
                );
            }
            else
            {
                if ($user->getEmail() == $this->getEmail())
                {
                    throw new UserValidationException(
                        'A user with this email address already exists.',
                        'email',
                        $this->getHandle()
                    );
                }
            }
            
            throw new UserValidationException(
                'Error. Please select another email address or username.',
                'email',
                $this->getHandle()
            );
            
        }
        
        return $this->beforeValidationOnUpdate();
    }
    
    /**
     * @return bool
     */
    public function beforeValidationOnUpdate()
    {
        parent::beforeValidationOnUpdate();
        
        if (strlen($this->getEmail()) < $this->emailMinimumLength)
        {
            throw new UserValidationException(
                sprintf('E-Mail address has to be at least %d characters long.', $this->emailMinimumLength),
                'email',
                $this->getEmail(),
                'Provide a valid email address'
            );
        }
        
        if (!strlen($this->getName()))
        {
            throw new UserValidationException(
                sprintf('Please provide a valid name.'),
                'name',
                $this->getName(),
                'Name is empty. Provide one.'
            );
        }
        
        $urlPattern = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
        if ($this->getWebsite() && !preg_match(
                $urlPattern,
                $this->getWebsite()
            ))
        {
            throw new UserValidationException(
                'Please provide a valid website in the following format: [http://]www.example.com',
                'website',
                $this->getWebsite(),
                'Please provide a valid website in the following format: [http://]www.example.com'
            );
        }
        
        // Check if username is given
        if (!$this->getHandle())
        {
            return false;
        }
        
        // Check if email is given
        if (!$this->getEmail())
        {
            return false;
        }
        
        return true;
    }

    /**
     * Find user by handle or email
     *
     * @param mixed $handle
     * @param mixed $email
     *
     * @return User|Model
     */
    public static function findFirstByHandleOrEmail($handle, $email)
    {
        return parent::findFirst(
            [
                "conditions" => "handle = ?0 OR email = ?1",
                "limit" => 1,
                "bind" => [$handle, $email],
            ]
        );
    }
}
