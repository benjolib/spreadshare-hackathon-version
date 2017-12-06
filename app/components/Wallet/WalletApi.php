<?php

namespace DS\Component\Wallet;

use DS\Model\User;
use DS\Model\Wallet;
use Phalcon\Exception;

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
class WalletApi extends AbstractWallet
{
    /**
     * @var string
     */
    private $lastWalletAddress = '';
    
    /**
     * Creates a new wallet for user associataed with UserModel $forUser
     *
     * @param User $forUser
     *
     * @return WalletApi
     */
    public function createWallet(User $forUser): WalletApi
    {
        // Create data package
        $data = [
            'userId' => $forUser->getId(),
            'email' => $forUser->getEmail(),
        ];
        
        /**
         * Post to create a new wallet
         */
        $response = $this->guzzleClient->post(
            '/address',
            [
                'body' => json_encode($data),
            ]
        );
        
        $responseObject = json_decode($response->getBody()->getContents());
        
        if (isset($responseObject->address))
        {
            // Save or create wallet for user
            Wallet::get($forUser->getId(), 'userId')
                  ->setUserId($forUser->getId())
                  ->setContractAddress($responseObject->address)
                  ->save();
        }
        else
        {
            throw new Exception('Error creating wallet. ' . var_export($responseObject, true));
        }
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getLastWalletAddress(): string
    {
        return $this->lastWalletAddress;
    }
}