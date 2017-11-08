<?php
namespace DS\Component\Mail\Events;

use DS\Component\Mail\MailEvent;
use DS\Component\Mail\ViewParams\DefaultParams;
use DS\Model\UserResetPassword;

/**
 * Spreadshare
 *
 * Mailing
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component\Mail
 */
class PasswordResetMail extends MailEvent
{
    /**
     * @var string
     */
    protected $subject = 'Spreadshare | Password Reset';

    /**
     * @param string            $mailAddress
     * @param string            $name
     * @param UserResetPassword $resetModel
     *
     * @return $this
     */
    public function prepare($mailAddress, $name, UserResetPassword $resetModel)
    {
        $viewParams                      = new DefaultParams();
        $viewParams->buttonText          = sprintf('Verify & Reset');
        $viewParams->buttonLink          = sprintf('https://%s/password/reset?code=%s', $this->getDI()->get('config')->get('domain'), $resetModel->getCode());
        $viewParams->showUnsubscribeLink = false;
        $viewParams->topMessage          = nl2br(
            sprintf(
                'Hi <strong>%s</strong>,

You\'ve recently asked to reset the password for this account:
%s

To update your password, click the button below:',
                $name,
                $mailAddress
            ),
            true
        );

        $viewParams->bottomMessage = sprintf('Button not working? Paste the following link into your browser: %s', $viewParams->buttonLink);
        
        $this->message =
            $this->mailManager->createMessageFromView($this->viewPath, $viewParams->toArray())
                              ->to($mailAddress, $name)
                              ->subject($this->subject);

        return $this;
    }
}
