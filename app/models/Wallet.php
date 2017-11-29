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
     * @param array $param
     * @param int   $page
     * @param int   $limit
     *
     * @return array
     */
    /*
    public function findCustom($param = [], $page = 0, $limit = Paging::endlessScrollPortions)
    {
        if (count($param))
        {
            return self::query()
                       ->columns(
                           [
                               Wallet::class . ".id",
                           ]
                       )
                //->leftJoin(Wallet::class, Wallet::class . '.profileId = ' . Profile::class . '.id')
                //->inWhere(Profile::class . '.id', $param)
                       ->limit((int) $limit, (int) Paging::endlessScrollPortions * $page)
                //->orderBy(sprintf('FIELD (id,%s)', implode(',', $param)))
                       ->execute()
                       ->toArray() ?: [];
        }
        
        return [];
    }
    */
    
    /**
     * @param int $userId
     * @param int $incrementBy
     *
     * @return Wallet
     */
    public static function incrementTokens(int $userId, $incrementBy = 1): Wallet
    {
        $wallet = self::get($userId, 'userId');
        $wallet->setTokens($wallet->getTokens() + $incrementBy)->save();
        
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
        $wallet->setTokens($wallet->getTokens() - $decrementBy)->save();
        
        return $wallet;
    }
}
