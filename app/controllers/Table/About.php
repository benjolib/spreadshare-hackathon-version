<?php

namespace DS\Controller\Table;

use DS\Controller\BaseController;
use DS\Interfaces\TableSubcontrollerInterface;
use DS\Model\TableComments;
use DS\Model\Tables;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller\User
 */
class About
    extends BaseController
    implements TableSubcontrollerInterface
{
    
    /**
     * Handle Subcontroller
     *
     * @param Tables $table
     *
     * @return $this
     */
    public function handle(Tables $table, int $userId)
    {
        try
        {
            $comments = new TableComments();
            
            if ($this->request->isPost())
            {
                if ($this->request->getPost('comment'))
                {
                    $comments->setUserId($this->serviceManager->getAuth()->getUserId())
                             ->setTableId($table->getId())
                             ->setParentId($this->request->getPost('parentId') ?: null)
                             ->setVotesCount(0)
                             ->setComment($this->request->getPost('comment'))
                             ->create();
                }
            }
            
            $commentsArray = $comments->getComments($table->getId());
            foreach ($commentsArray as $key => $comment)
            {
                $commentsArray[$key]['childs'] = $comments->getComments($table->getId(), $comment['id']);
            }
            
            $this->view->setVar('comments', $commentsArray);
            $this->view->setMainView('table/detail/about');
            
            $this->view->setVar('selectedPage', 'about');
        }
        catch (\Exception $e)
        {
            throw $e;
        }
        
        return $this;
    }
}