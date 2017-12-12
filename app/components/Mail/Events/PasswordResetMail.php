<?php

namespace DS\Component\Mail\Events;

use DS\Component\Mail\MailEvent;
use DS\Component\Mail\ViewParams\DefaultParams;
use DS\Model\Events\UserResetPasswordEvents;
use DS\Model\User;

/**
 * Spreadshare
 *
 * Mailing
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component\Mail
 */
class PasswordResetMail extends MailEvent
{
    /**
     * @var string
     */
    protected $subject = 'Reset Your SpreadShare Password';
    
    /**
     * @param User                    $userModel
     * @param UserResetPasswordEvents $resetModel
     *
     * @return $this
     */
    public function prepare(User $userModel, UserResetPasswordEvents $resetModel)
    {
        $viewParams             = new DefaultParams();
        $viewParams->buttonText = sprintf('Reset Password');
        $viewParams->buttonLink = $this->prepareUrl(sprintf('/login/forgot/%s', $resetModel->getCode()));;
        
        $viewParams->showUnsubscribeLink = false;
        $viewParams->topMessage          = nl2br(
            sprintf(
                '%s, you have requested to reset your password.
Click the following link and choose a new password.',
                $userModel->getName()
            ),
            true
        );
        
        $viewParams->bottomMessage = sprintf('Button not working? Paste the following link into your browser: %s', $viewParams->buttonLink);
        
        $this->prepareUserMessage($viewParams, $userModel);
        
        return $this;
    }
}
