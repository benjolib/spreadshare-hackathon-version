<?php

namespace DS\Controller\Api\v1\Reply;

use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Record;
use DS\Controller\Api\MethodInterface;
use DS\Model\Comments;
use DS\Model\Decks;

/**
 *
 * Spreadshare
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
class Post extends ActionHandler implements MethodInterface
{
    /**
     * @return bool
     */
    public function needsLogin()
    {
        return false;
    }
    
    /**
     * Process Get Method
     *
     * @return mixed
     */
    public function process()
    {
        if ($this->request->isAjax())
        {
            $commentId = $this->action;
            $userId    = $this->getServiceManager()->getAuth()->getUserId();
            
            if ($userId > 0 && $this->request->getPost('comment'))
            {
                $parent = Comments::findFirstById($commentId);
                if ($parent)
                {
                    $comments = new Comments();
                    $comments->setDeckId($parent->getDeckId())
                             ->setCommentId($commentId)
                             ->setUserId($userId)
                             ->setComment($this->request->getPost('comment'))
                             ->setCreatedAt(time())
                             ->create();
                    
                    $deck = Decks::findFirstById($parent->getDeckId());
                    $deck->setCommentsCount($deck->getCommentsCount() + 1)->save();
                    
                    return new Record(['success' => 1]);
                }
            }
        }
        
        return new Record("Nothing to do here");
    }
    
}
