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
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component\Mail
 */
class PasswordChangedMail extends MailEvent
{
    /**
     * @var string
     */
    protected $subject = 'Spreadshare | Password Change';

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
        $viewParams->showUnsubscribeLink = false;
        $viewParams->topMessage          = nl2br(
            sprintf(
                'Hi <strong>%s</strong>,

Your password has been changed successfully.

Please contact us if you did not authorize this transaction.
',
                $userModel->getGivenName()
            ),
            true
        );

        $this->prepareUserMessage($viewParams, $userModel);

        return $this;
    }
}
