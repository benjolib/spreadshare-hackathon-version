<?php

namespace DS\Component\Mail\Events;

use DS\Component\Links\UserLink;
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
class NewFollowerMail extends MailEvent
{
    /**
     * @var string
     */
    protected $subject = 'New Follower';
    
    /**
     * Prepare mail parameters
     *
     * @param UserEvents $userModel
     * @param UserEvents $followerUserModel
     *
     * @return $this
     */
    public function prepare(UserEvents $userModel, UserEvents $followerUserModel)
    {
        $viewParams                      = new DefaultParams();
        $viewParams->showUnsubscribeLink = true;
        $viewParams->buttonText          = sprintf('View Profile');
        $viewParams->buttonLink          = UserLink::get($followerUserModel->getHandle());
        $viewParams->headerMessage       = sprintf("%s started following you", $followerUserModel->getName());
        $viewParams->topMessage          = nl2br(
            sprintf(
                'Want to know who <a href="%s">%s</a> is?',
                $viewParams->buttonLink,
                $followerUserModel->getName()
            ),
            true
        );
        $viewParams->bottomMessage       = $this->buttonNotWorkingMessage($viewParams);
        
        $this->prepareUserMessage($viewParams, $userModel);
        
        return $this;
    }
}
