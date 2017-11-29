<?php

namespace DS\Model;

use DS\Component\ServiceManager;
use DS\Model\Events\TableRowVotesEvents;
use DS\Traits\Model\FindUserAndRowTrait;

/**
 * TableRowVotes
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
class TableRowVotes
    extends TableRowVotesEvents
{
    use FindUserAndRowTrait;
    
    /**
     * @param int $userId
     * @param int $limit
     *
     * @return self
     */
    public static function getUpvotedRowsByUser(int $userId, $limit = 50)
    {
        return self::find(
            [
                "conditions" => 'userId = ?0',
                "bind" => [$userId],
                "limit" => $limit,
                "order" => 'createdAt DESC',
            ]
        );
    }
    
    /**
     * @param int $rowId
     * @param int $userId
     *
     * @return bool
     */
    public function votedForRow(int $rowId, int $userId = null)
    {
        if ($userId === null)
        {
            $userId = ServiceManager::instance($this->getDI())->getAuth()->getUserId();
        }
        
        return self::findFirst(
            [
                "conditions" => 'userId = ?0 AND rowId = ?1',
                "bind" => [$userId, $rowId],
                "limit" => 1,
            ]
        ) ? true : false;
    }
}
