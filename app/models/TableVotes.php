<?php

namespace DS\Model;

use DS\Component\ServiceManager;
use DS\Model\Abstracts\AbstractTableVotes;

/**
 * Votes
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 *
 * @method static findFirstById(int $id)
 */
class TableVotes
    extends AbstractTableVotes
{
    /**
     * @param int $userId
     * @param int $tableId
     *
     * @return AbstractTableVotes|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findVote(int $userId, int $tableId)
    {
        return self::findFirst(
            [
                "conditions" => 'userId = ?0 AND tableId = ?1',
                "bind" => [$userId, $tableId],
                "limit" => 1,
            ]
        );
    }
    
    /**
     * @param int $userId
     * @param int $limit
     *
     * @return AbstractTableVotes|AbstractTableVotes[]|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function getUpvotedTableByUser(int $userId, $limit = 50)
    {
        return self::find(
            [
                "conditions" => 'userId = ?0',
                "bind" => [$userId],
                "limit" => $limit,
            ]
        );
    }
    
    /**
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
        
        return self::findFirst(
            [
                "conditions" => 'userId = ?0 AND tableId = ?1',
                "bind" => [$userId, $tableId],
                "limit" => 1,
            ]
        ) ? true : false;
    }
}
