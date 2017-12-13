<?php

namespace DS\Component\Mail\Events;

use DS\Component\Links\TableCommentsLink;
use DS\Component\Links\UserLink;
use DS\Component\Mail\MailEvent;
use DS\Component\Mail\ViewParams\DefaultParams;
use DS\Model\Events\TableCommentsEvents;
use DS\Model\Tables;
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
class NewCommentMail extends MailEvent
{
    /**
     * @var string
     */
    protected $subject = 'New Comment';
    
    /**
     * @param User                $recipientUserModel
     * @param Tables              $table
     * @param TableCommentsEvents $commentModel
     *
     * @return $this
     */
    public function prepare(User $recipientUserModel, Tables $table, TableCommentsEvents $commentModel)
    {
        $commenterUserModel = User::get($commentModel->getUserId());
        
        $viewParams                      = new DefaultParams();
        $viewParams->showUnsubscribeLink = true;
        $viewParams->buttonText          = sprintf('View Comment');
        $viewParams->buttonLink          = TableCommentsLink::get($table->getId());
        $viewParams->headerMessage       = $this->subject;
        $viewParams->topMessage          = nl2br(
            sprintf(
                '<a href="%s">%s</a> added a new comment to table <strong>%s</strong>:

 %s',
                UserLink::get($commenterUserModel->getHandle()),
                $commenterUserModel->getHandle(),
                $table->getTitle(),
                $commentModel->getComment()
            ),
            true
        );
        $viewParams->bottomMessage       = $this->buttonNotWorkingMessage($viewParams);
        
        $this->prepareUserMessage($viewParams, $recipientUserModel);
        
        return $this;
    }
}
