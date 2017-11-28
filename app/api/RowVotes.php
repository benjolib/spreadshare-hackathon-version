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
     * Vote for a table's row
     *
     * @param int $userId
     * @param int $rowId
     *
     * @return bool
     */
    public function voteForRow(int $userId, int $rowId): bool
    {   
        $row = TableRows::findFirstById($rowId);
        if (!$row)
        {
            throw new \InvalidArgumentException('This row does not exist.');
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