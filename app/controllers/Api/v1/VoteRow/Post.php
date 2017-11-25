<?php

namespace DS\Controller\Api\v1\VoteRow;

use DS\Api\RowVotes;
use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Record;
use DS\Controller\Api\MethodInterface;

/**
 *
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
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
        return true;
    }
    
    /**
     * Process Get Method
     *
     * @return mixed
     */
    public function process()
    {
        if ($this->request->isAjax() && $this->action)
        {
            $userId = $this->getServiceManager()->getAuth()->getUserId();
            
            if ($userId > 0)
            {
                return new Record(['voted' => (new RowVotes())->voteForRow($userId, $this->action, $this->request->getPost('lineNumber'))]);
            }
        }
        
        return new Record("Nothing to do here");
    }
    
}
