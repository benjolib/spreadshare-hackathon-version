<?php

namespace DS\Model\Events;

use DS\Model\Abstracts\AbstractTableTokens;
use DS\Model\TableStats;
use DS\Model\Wallet;

/**
 * Events for model TableTokens
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
abstract class TableTokensEvents
    extends AbstractTableTokens
{
    
    /**
     * @return bool
     */
    public function beforeValidationOnCreate()
    {
        parent::beforeValidationOnCreate();
        
        return true;
    }
    
    /**
     * @return bool
     */
    public function beforeValidationOnUpdate()
    {
        parent::beforeValidationOnUpdate();
        
        return true;
    }
    
    /**
     * After distributing a token
     */
    public function afterCreate()
    {
        if ($this->getTableId())
        {
            $tableStats = TableStats::findByFieldValue('tableId', $this->getTableId());
            $tableStats->setTokensCount($tableStats->getTokensCount() + 1)->save();
        }
        
        if ($this->getUserId())
        {
            Wallet::incrementTokens($this->getUserId());
        }
    }
    
    /**
     * Before deleting a distributed token
     */
    public function beforeDelete()
    {
        if ($this->getTableId())
        {
            $tableStats = TableStats::findByFieldValue('tableId', $this->getTableId());
            $tableStats->setTokensCount($tableStats->getTokensCount() - 1)->save();
        }
        
        if ($this->getUserId())
        {
            Wallet::decrementTokens($this->getUserId());
        }
    }
}
