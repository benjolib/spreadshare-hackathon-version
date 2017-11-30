<?php

namespace DS\Model\Events;

use DS\Exceptions\ModelFieldNotNullException;
use DS\Model\Abstracts\AbstractWallet;

/**
 * Events for model Wallet
 *
 * @see       https://docs.phalconphp.com/ar/3.2/db-models-events
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 */
abstract class WalletEvents
    extends AbstractWallet
{
    
    /**
     * @return bool
     */
    public function beforeValidationOnCreate()
    {
        parent::beforeValidationOnCreate();
        
        if (!$this->getUserId())
        {
            throw new ModelFieldNotNullException($this, "There was no user id set for the wallet.");
        }
        
        return true;
    }
    
    /**
     * @return bool
     */
    public function beforeValidationOnUpdate()
    {
        parent::beforeValidationOnUpdate();
        
        if (!$this->getUserId())
        {
            throw new ModelFieldNotNullException($this, "There was no user id set for the wallet.");
        }
        
        return true;
    }
}
