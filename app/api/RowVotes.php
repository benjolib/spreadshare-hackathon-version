<?php

namespace DS\Api;

use DS\Model\TableRows;
use DS\Model\TableRowVotes;

/**
 * Spreadshare
 *
 * User Settings Api
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
class RowVotes
    extends BaseApi
{
    
    /**
     * Vote for a table. Returns true if user upvoted, false if downvoted.
     *
     * @param int   $userId
     * @param array $topicIds
     *
     * @return bool
     */
    public function voteForRow(int $userId, int $tableId, int $lineNumber): bool
    {
        $row = TableRows::findByTableIdAndLineNumber($tableId, $lineNumber);
        if ($row)
        {
            throw new \InvalidArgumentException('Line number does not exist for this table.');
        }
        
        $votes = TableRowVotes::findVote($userId, $row->getId());
        
        if ($votes)
        {
            $votes->delete();
            $row->setVotesCount($row->getVotesCount() - 1)->save();
            
            return false;
        }
        
        $tableVotes = new TableRowVotes();
        $tableVotes->setUserId($userId)
                   ->setRowId($row->getId())
                   ->create();
        
        $row->setVotesCount($row->getVotesCount() + 1)->save();
        
        return true;
    }
}