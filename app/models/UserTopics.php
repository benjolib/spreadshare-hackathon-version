<?php

namespace DS\Model;

use DS\Model\Events\UserTopicsEvents;

/**
 * UserSettings
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
class UserTopics extends UserTopicsEvents
{
    
    /**
     * Reassign all topic ids
     *
     * @param int   $userId
     * @param array $topicIds
     *
     * @return $this
     */
    public function setTopicsByUserId(int $userId, array $topicIds): UserTopics
    {
        // Remove all topics for user
        $this->getWriteConnection()->delete($this->getSource(), "userId = '{$userId}'");
        
        // ... and recreate them
        foreach ($topicIds as $id) {
            (new self())->setUserId($userId)->setTopicId($id)->create();
        }
        
        return $this;
    }
}
