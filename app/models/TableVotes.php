<?php

namespace DS\Model;

use DS\Component\ServiceManager;
use DS\Model\Events\TableVotesEvents;

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
    /**
     * Check if a user voted for a specific table
     *
     * @param int $userId
     * @param int $tableId
     *
     * @return TableVotes|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findVote(int $userId, int $tableId)
    {
        return TableVotes::findFirst(
            [
                "conditions" => 'userId = ?0 AND tableId = ?1',
                "bind" => [$userId, $tableId],
                "limit" => 1,
            ]
        );
    }
    
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
        
        return self::findVote($userId, $tableId) ? true : false;
    }
}
