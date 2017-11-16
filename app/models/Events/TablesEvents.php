<?php

namespace DS\Model\Events;

use DS\Model\Abstracts\AbstractTables;
use DS\Model\DataSource\TableLogType;
use DS\Model\TableLog;
use DS\Model\TableRows;
use DS\Model\TableStats;
use DS\Model\TableTokens;

/**
 * Events for model Tables
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
abstract class TablesEvents
    extends AbstractTables
{
    
    /**
     * @return bool
     */
    public function beforeCreate()
    {
        parent::beforeCreate();
        
        return true;
    }
    
    /**
     * @return bool
     */
    public function afterCreate()
    {
        // Initialize table stats
        $tableStats = new TableStats();
        $tableStats->setTableId($this->getId())->create();
        
        // Initialize table rows
        $tableRows = new TableRows();
        $tableRows->setUserId($this->getOwnerUserId())
                  ->setContent('[]')
                  ->setVotesCount(0)
                  ->setCommentsCount(0)
                  ->create();
        
        // Initialize table log with a table created entry
        $tableLog = new TableLog();
        $tableLog->setTableId($this->getId())
                 ->setLogType(TableLogType::Created)
                 ->setUserId($this->getOwnerUserId())
                 ->setPlaceholders('')
                 ->setText('Table created.')
                 ->create();
        
        // Initialize table tokens with an amout of zero tokens
        $tableTokens = new TableTokens();
        $tableTokens->setTableId($this->getId())
                    ->setTokensEarned(0)
                    ->setOwnership(0)
                    ->setUserId($this->getOwnerUserId())
                    ->create();
        
        return true;
    }
    
    /**
     * @return bool
     */
    public function beforeSave()
    {
        parent::beforeSave();
        
        return true;
    }
}
