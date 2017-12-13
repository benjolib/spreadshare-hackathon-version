<?php

namespace DS\Component\Mail\Events;

use DS\Component\Mail\MailEvent;
use DS\Component\Mail\ViewParams\DefaultParams;
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
class SignupMail extends MailEvent
{
    /**
     * @var string
     */
    protected $subject = 'Welcome to Spreadshare!';
    
    /**
     * Prepare mail parameters for this signup email
     *
     * @param User $userModel
     *
     * @return $this
     */
    public function prepare(User $userModel)
    {
        $viewParams                      = new DefaultParams();
        $viewParams->showUnsubscribeLink = true;
        $viewParams->buttonText          = sprintf('Confirm Email Address');
        $viewParams->buttonLink          = $this->prepareUrl(sprintf('/login?token=%s', $userModel->getEmailConfirmationToken()));
        $viewParams->headerMessage       = "Confirm your Email Address";
        $viewParams->topMessage          = nl2br(
            sprintf(
                'Hello <strong>%s</strong>,

Welcome to Spreadshare!

We just need to verify that <strong>%s</strong> is your email address, and then we\'ll let you explore and create great tables.
',
                $userModel->getName(),
                $userModel->getEmail()
            ),
            true
        );
        
        $viewParams->bottomMessage = sprintf('Button not working? Paste the following link into your browser: %s', $viewParams->buttonLink);
        
        $this->prepareUserMessage($viewParams, $userModel);
        
        return $this;
    }
}
