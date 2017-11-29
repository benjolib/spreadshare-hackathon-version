<?php

namespace DS\Api;

use DS\Model\Tables;
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
        $table = Tables::findFirstById($tableId);
        if (!$table)
        {
            throw new \InvalidArgumentException('Table does not exist.');
        }
        
        if ($table->getOwnerUserId() == $this->serviceManager->getAuth()->getUserId())
        {
            throw new \InvalidArgumentException('You can not upvote your own table.');
        }
        
        $votes      = TableVotesModel::findByUserIdAndTable($userId, $tableId);
        
        if ($votes)
        {
            $votes->delete();
            
            return false;
        }
        
        $tableVotes = new TableVotesModel();
        $tableVotes->setUserId($userId)
                   ->setTableId($tableId)
                   ->create();
        
        return true;
    }
}