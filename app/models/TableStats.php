<?php

namespace DS\Model;

use DS\Model\Events\TableStatsEvents;

/**
 * TableStats
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
class TableStats
    extends TableStatsEvents
{
    /**
     * @param int    $tableId
     * @param string $field
     */
    public function increment(int $tableId, string $field = 'comments')
    {
        $stats = $this->getStatsInstance($tableId);
        
        call_user_func_array(
            [
                $stats,
                'set' . ucfirst($field) . 'Count',
            ],
            [
                call_user_func(
                    [$stats, 'get' . ucfirst($field) . 'Count']
                ) + 1,
            ]
        );
        
        $stats->save();
    }
    
    /**
     * @param int    $tableId
     * @param string $field
     */
    public function decrement(int $tableId, string $field = 'comments')
    {
        $stats = $this->getStatsInstance($tableId);
        
        call_user_func_array(
            [
                $stats,
                'set' . ucfirst($field) . 'Count',
            ],
            [
                call_user_func(
                    [$stats, 'get' . ucfirst($field) . 'Count']
                ) - 1,
            ]
        );
        
        $stats->save();
    }
    
    private function getStatsInstance($tableId)
    {
        $stats = self::findByFieldValue('tableId', $tableId);
        if (!$stats)
        {
            $stats = new self();
            $stats->setTableId($tableId);
        }
        
        return $stats;
    }
    
    public function initialize()
    {
        parent::initialize();
        
        $this->setCommentsCount(0)
             ->setTokensCount(0)
             ->setVotesCount(0)
             ->setViewsCount(0)
             ->setSubscriberCount(0)
             ->setContributionCount(0);
    }
}
