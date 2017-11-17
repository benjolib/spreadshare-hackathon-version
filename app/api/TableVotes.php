<?php

namespace DS\Api;

use DS\Model\TableStats;
use DS\Model\TableVotes as TableVotesModel;

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
class TableVotes
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
    public function voteForTable(int $userId, int $tableId): bool
    {
        $votes      = TableVotesModel::findVote($userId, $tableId);
        $tableStats = TableStats::findByFieldValue('tableId', $tableId);
        if (!$tableStats)
        {
            $tableStats = new TableStats();
            $tableStats->setTableId($tableId)->create();
        }
        
        if ($votes)
        {
            $votes->delete();
            $tableStats->setVotesCount($tableStats->getVotesCount() - 1)->save();
            
            return false;
        }
        
        $tableVotes = new TableVotesModel();
        $tableVotes->setUserId($userId)
                   ->setTableId($tableId)
                   ->create();
        
        $tableStats->setVotesCount($tableStats->getVotesCount() + 1)->save();
        
        return true;
    }
}