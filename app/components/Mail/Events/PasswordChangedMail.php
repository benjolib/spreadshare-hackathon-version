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
class PasswordChangedMail extends MailEvent
{
    /**
     * @var string
     */
    protected $subject = 'Your Password Has Been Changed';
    
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
        $viewParams->headerMessage       = $this->subject;
        $viewParams->topMessage          = nl2br(
            sprintf(
                '%s, your SpreadShare password has been changed.
If you did not request this change, please contact our support team',
                $userModel->getName()
            ),
            true
        );
        
        $this->prepareUserMessage($viewParams, $userModel);
        
        return $this;
    }
}
