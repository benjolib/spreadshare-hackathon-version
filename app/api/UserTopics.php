<?php

namespace DS\Api;

use DS\Model\UserTopics as UserTopicsModel;

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
class UserTopics
    extends BaseApi
{
    
    /**
     * @param int   $userId
     * @param array $topicIds
     *
     * @return UserTopicsModel
     */
    public function saveUserTopics(int $userId, array $topicIds)
    {
        $userTopics = new UserTopicsModel();
        if (count($topicIds))
        {
            $userTopics->setTopicsByUserId($userId, $topicIds);
        }
        
        return $userTopics;
    }
}