<?php

namespace DS\Traits\Model;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Interfaces
 */
trait UserStatsTrait
{
    /**
     * @param int    $userId
     * @param string $field
     * @param int    $by
     *
     * @return bool
     */
    public static function increment(int $userId, string $field = 'contributions', int $by = 1)
    {
        $stats = self::getStatsInstance($userId);
        
        call_user_func_array(
            [
                $stats,
                'set' . ucfirst($field) . 'Count',
            ],
            [
                call_user_func(
                    [$stats, 'get' . ucfirst($field) . 'Count']
                ) + $by,
            ]
        );
        
        return $stats->save();
    }
    
    /**
     * @param int    $userId
     * @param string $field
     * @param int    $by
     *
     * @return bool
     */
    public static function decrement(int $userId, string $field = 'contributions', int $by = 1)
    {
        $stats = self::getStatsInstance($userId);
        
        call_user_func_array(
            [
                $stats,
                'set' . ucfirst($field) . 'Count',
            ],
            [
                call_user_func(
                    [$stats, 'get' . ucfirst($field) . 'Count']
                ) - $by,
            ]
        );
        
        return $stats->save();
    }
    
    /**
     * @param int $userId
     *
     * @return static
     */
    private static function getStatsInstance(int $userId)
    {
        $stats = self::findByFieldValue('userId', $userId);
        if (!$stats)
        {
            $stats = new self();
            $stats->setUserId($userId);
        }
        
        return $stats;
    }
}
