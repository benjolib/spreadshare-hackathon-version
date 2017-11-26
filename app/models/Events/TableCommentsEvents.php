<?php

namespace DS\Model\Events;

use DS\Model\Abstracts\AbstractTableComments;
use DS\Model\TableStats;

/**
 * Events for model TableComments
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
abstract class TableCommentsEvents
    extends AbstractTableComments
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
    public function beforeSave()
    {
        parent::beforeSave();
        
        return true;
    }
    
    /**
     * @return bool
     */
    public function afterSave()
    {
        (new TableStats())->increment($this->getTableId(), 'comments');
        
        return true;
    }
}
