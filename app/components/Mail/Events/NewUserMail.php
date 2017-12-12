<?php

namespace DS\Component\Mail\Events;

use DS\Component\Mail\MailEvent;
use DS\Component\Mail\ViewParams\DefaultParams;
use DS\Model\Events\UserEvents;
use Phalcon\Mailer\Message;

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
class NewUserMail extends MailEvent
{
    /**
     * @var string
     */
    protected $subject = 'New User!';
    
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
        
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir(ROOT_PATH . '/app/views/');
        
        $mailContent =
            
            nl2br(
                sprintf(
                    'There is a new user Signup via %s:

<strong>%s</strong>,
<strong>%s</strong>,
<a href="%s/user/%s">%s</a>,
',
                    $userModel->getAuthProvider() ?: 'Spreadshare',
                    $userModel->getName(),
                    $userModel->getEmail(),
                    $this->prepareUrl(),
                    $userModel->getHandle(),
                    $userModel->getHandle()
                ),
                true
            );
        
        $this->message = $this->mailManager->createMessage()
                                           ->content($mailContent, Message::CONTENT_TYPE_PLAIN)
                                           ->to('samson.harrish@gmail.com')
                                           ->subject($this->subject);
        
        return $this;
    }
}
