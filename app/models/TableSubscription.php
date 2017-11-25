<?php

namespace DS\Model;

use DS\Model\Events\TableSubscriptionEvents;

/**
 * TableSubscription
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
    extends TableSubscriptionEvents
{
    /**
     * @param int $userId
     * @param int $tableId
     *
     * @return $this
     */
    public function subscribe(int $userId, int $tableId)
    {
        $this->setUserId($userId)
             ->setTableId($tableId)
             ->create();
        
        return $this;
    }
    
    /**
     * @param int $userId
     * @param int $tableId
     *
     * @return $this
     */
    public function unsubscribe(int $userId, int $tableId)
    {
        $model = static::findSubscription($userId, $tableId);
        if ($model)
        {
            $model->delete();
        }
        
        return $this;
    }
    
    /**
     * Allows to query this model by the given sql field name and it's value
     *
     * @param string $field
     * @param string $value
     *
     * @return static
     */
    public static function findSubscription(int $userId, int $tableId)
    {
        return self::findFirst(
            [
                "conditions" => 'tableId = ?0 AND userId = ?1',
                "limit" => 1,
                "bind" => [$tableId, $userId],
            ]
        );
    }
}
