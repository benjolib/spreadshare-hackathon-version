<?php

namespace DS\Api;

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
class TableSubscription
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
    public function subscribeTable(int $userId, int $tableId): bool
    {
        if ($userId && $tableId)
        {
            $model        = new \DS\Model\TableSubscription();
            $subscription = $model->findSubscription($userId, $tableId);
            
            if ($subscription)
            {
                // Unsubscribe
                $subscription->delete();
                
                return false;
            }
            else
            {
                $model->subscribe($userId, $tableId);
                
                return true;
            }
            
        }
        
        throw new \InvalidArgumentException('Invalid user or table id');
    }
}