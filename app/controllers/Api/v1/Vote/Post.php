<?php

namespace DS\Controller\Api\v1\Vote;

use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Record;
use DS\Controller\Api\MethodInterface;
use DS\Model\Decks;
use DS\Model\Votes;

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
            $deckId = $this->action;
            $userId = $this->getServiceManager()->getAuth()->getUserId();
            
            if ($userId > 0)
            {
                $votes = Votes::findVote($userId, $deckId);
                $deck  = Decks::findFirstById($deckId);
                if ($votes)
                {
                    $votes->delete();
                    $deck->setVotesCount($deck->getVotesCount() - 1)->save();
                    
                    return new Record(['voted' => 0]);
                }
                else
                {
                    $votes = new Votes();
                    $votes->setUserId($userId)
                          ->setDeckId($deckId)
                          ->create();
                    
                    $deck->setVotesCount($deck->getVotesCount() + 1)->save();
                }
                
                return new Record(['voted' => 1]);
            }
        }
        
        return new Record("Nothing to do here");
    }
    
}
