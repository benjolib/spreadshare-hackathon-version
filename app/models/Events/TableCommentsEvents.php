<?php

namespace DS\Model\Events;

use DS\Component\Text\Emoji;
use DS\Events\Table\TableCommented;
use DS\Model\Abstracts\AbstractTableComments;
use DS\Model\Tables;
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
    public function beforeValidationOnCreate()
    {
        parent::beforeValidationOnCreate();
        
        // Convert Emojis to their UTF-8 hex notation
        $emoji = new Emoji();
        $this->setComment($emoji->convert($this->getComment()));
        
        return true;
    }
    
    /**
     * @return bool
     */
    public function beforeValidationOnUpdate()
    {
        parent::beforeValidationOnUpdate();
        
        return $this->beforeValidationOnCreate();
    }
    
    /**
     * @return bool
     */
    public function afterSave()
    {
        (new TableStats())->increment($this->getTableId(), 'comments');
        
        TableCommented::after($this->userId, Tables::get($this->getTableId()));
        
        return true;
    }
}
