<?php

namespace DS\Model;

use DS\Component\ServiceManager;
use DS\Model\Events\TableVotesEvents;
use DS\Traits\Model\FindUserAndTableTrait;

/**
 * TableVotes
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
    extends TableVotesEvents
{
    use FindUserAndTableTrait;
    
    /**
     * Get tables that are upvoted by userId
     *
     * @param int $userId
     * @param int $limit
     *
     * @return TableVotes|TableVotes[]|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function getUpvotedTablesByUser(int $userId, $limit = 50)
    {
        return TableVotes::find(
            [
                "conditions" => 'userId = ?0',
                "bind" => [$userId],
                "limit" => $limit,
            ]
        );
    }
    
    /**
     * Check wheather a user has already voted for a table
     *
     * @param int $tableId
     * @param int $userId
     *
     * @return bool
     */
    public function votedForTable(int $tableId, int $userId = null)
    {
        if ($userId === null)
        {
            $userId = ServiceManager::instance($this->getDI())->getAuth()->getUserId();
        }
        
        return $this->findByUserIdAndTable($userId, $tableId) ? true : false;
    }
}
