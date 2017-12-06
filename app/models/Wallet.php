<?php

namespace DS\Model;

use DS\Model\Events\WalletEvents;

/**
 * Wallet
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
class Wallet
    extends WalletEvents
{
    /**
     * @param int $userId
     * @param int $incrementBy
     *
     * @return Wallet
     */
    public static function incrementTokens(int $userId, $incrementBy = 1): Wallet
    {
        $wallet = self::get($userId, 'userId');
        $wallet->setUserId($userId)->setTokens($wallet->getTokens() + $incrementBy)->save();
        
        return $wallet;
    }
    
    /**
     * @param int $userId
     * @param int $incrementBy
     *
     * @return Wallet
     */
    public static function decrementTokens(int $userId, $decrementBy = 1): Wallet
    {
        $wallet = self::get($userId, 'userId');
        $wallet->setUserId($userId)->setTokens($wallet->getTokens() - $decrementBy)->save();
        
        return $wallet;
    }
}
