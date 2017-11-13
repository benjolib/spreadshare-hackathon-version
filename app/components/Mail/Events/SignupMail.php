<?php

namespace DS\Component\Mail\Events;

use DS\Component\Mail\MailEvent;
use DS\Component\Mail\ViewParams\DefaultParams;
use DS\Model\Events\UserEvents;

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
     * @param UserEvents $userModel
     *
     * @return $this
     */
    public function prepare(UserEvents $userModel)
    {
        $viewParams                      = new DefaultParams();
        $viewParams->showUnsubscribeLink = false;
        $viewParams->buttonText          = sprintf('Verify');
        $viewParams->buttonLink          = sprintf(request()->getScheme() . '://%s/login?token=%s', $this->getDI()->get('config')->get('domain'), $userModel->getEmailConfirmationToken());
        $viewParams->topMessage          = nl2br(
            sprintf(
                'Hi <strong>%s</strong>,

Welcome to Spreadshare!

To make sure we have your correct email address, please confirm it by clicking the link below.
',
                $userModel->getName()
            ),
            true
        );
        
        $viewParams->bottomMessage = sprintf('Button not working? Paste the following link into your browser: %s', $viewParams->buttonLink);
        
        $this->prepareUserMessage($viewParams, $userModel);
        
        /**
         * @todo Remove the next line once emails are working....
         */
        echo $this->message->getContent();
        die;
        
        return $this;
    }
}
