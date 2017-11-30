<?php

namespace DS\Model;

use DS\Model\Events\TableCommentVotesEvents;

/**
 * TableCommentVotes
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 *
 * @method static findFirstById(int $id)
 */
class TableCommentVotes
    extends TableCommentVotesEvents
{
    
    /**
     * @param int $userId
     * @param int $commentId
     *
     * @return bool
     */
    public function vote(int $userId, int $commentId): bool
    {
        $row = TableComments::get($commentId);
        if (!$row->getTableId())
        {
            throw new \InvalidArgumentException('This comment does not exist.');
        }
        
        $votes = self::findByUserIdAndComment($userId, $row->getId());
        
        if ($votes)
        {
            $votes->delete();
            $row->setVotesCount($row->getVotesCount() - 1)->save();
            
            return false;
        }
        
        $tableVotes = new self();
        $tableVotes->setUserId($userId)
                   ->setCommentId($row->getId())
                   ->create();
        
        $row->setVotesCount($row->getVotesCount() + 1)->save();
        
        return true;
    }
    
    /**
     * @param int $userId
     * @param int $rowId
     *
     * @return self
     */
    public static function findByUserIdAndComment(int $userId, int $commentId)
    {
        return self::findFirst(
            [
                "conditions" => 'userId = ?0 AND commentId = ?1',
                "bind" => [$userId, $commentId],
                "limit" => 1,
            ]
        );
    }
}
