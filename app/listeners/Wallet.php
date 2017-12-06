<?php

namespace DS\Listeners;

use Bernard\Message\PlainMessage;
use DS\Application;
use DS\Component\ServiceManager;
use DS\Model\User;
use Phalcon\Logger;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component
 */
class Wallet
{
    
    /**
     * @param PlainMessage $message
     *
     * @throws \Phalcon\Exception
     */
    public function newWallet(PlainMessage $message)
    {
        
        try
        {
            if (!isset($message['userId']) || !$message['userId'])
            {
                throw new \InvalidArgumentException('userId not set in message');
            }
            
            // Get usermodel and validate the id
            $user = User::findFirstById($message['userId']);
            
            if (!$user)
            {
                throw new \InvalidArgumentException('invalid userId for message');
            }
            
            // Call wallet api to create a new wallet
            $walletApi = ServiceManager::instance()->getWalletApi();
            $walletApi->createWallet($user);
        }
        catch (\Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
        
    }
}
