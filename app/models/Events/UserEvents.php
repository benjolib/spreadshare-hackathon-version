<?php

namespace DS\Model\Events;

use DS\Component\Mail\Events\SignupMail;
use DS\Exceptions\UserValidationException;
use DS\Model\Abstracts\AbstractUser;
use DS\Model\DataSource\UserStatus;
use DS\Model\User;
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
     * @return bool
     */
    public function beforeCreate()
    {
        parent::beforeCreate();
        
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
        
        $this->emailConfirmationToken = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(24)));
        
        $this->setConfirmed(0)
             ->setStatus(UserStatus::Unconfirmed);
        
        return true;
    }
    
    /**
     * @return bool
     */
    public function beforeSave()
    {
        parent::beforeSave();
        
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
    
    /**
     * @return bool
     */
    public function beforeValidationOnCreate()
    {
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
        
        // Check if user with hande or email address already exists
        if (self::findFirstByHandleOrEmail($this->getHandle(), $this->getEmail()))
        {
            throw new UserValidationException('A user with this email address or username already exists.');
        }
        
        return true;
    }
}
