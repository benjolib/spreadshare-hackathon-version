<?php

namespace DS\Model\Events;

use DS\Component\Mail\Events\PasswordResetMail;
use DS\Model\Abstracts\AbstractUserResetPassword;

/**
 * Events for model UserResetPassword
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
abstract class UserResetPasswordEvents
    extends AbstractUserResetPassword
{
    /**
     * @return bool
     */
    public function beforeValidationOnCreate()
    {
        parent::beforeValidationOnCreate();
        
        if (!$this->userId || $this->userId < 1)
        {
            return false;
        }
        
        //Generate a random confirmation code
        $this->code = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(24)));
        
        //Set status to non-confirmed
        $this->status = 0;
        
        return true;
    }
    
    /**
     * @return bool
     */
    public function beforeValidationOnUpdate()
    {
        parent::beforeValidationOnUpdate();
        
        return true;
    }
    
    /**
     * Delete other open password resets before creating
     */
    public function beforeCreate()
    {
        $this->writeQuery('DELETE FROM userResetPassword WHERE userId = ' . (int) $this->userId . ' AND status = 0;', [])->execute();
    }
    
    /**
     * Send an e-mail to users allowing him/her to reset his/her password.
     */
    public function afterCreate()
    {
        PasswordResetMail::factory($this->getDI())
                         ->prepare($this->User, $this)
                         ->send();
    }
}
