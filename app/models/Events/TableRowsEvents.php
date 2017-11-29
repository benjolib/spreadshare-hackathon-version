<?php

namespace DS\Model\Events;

use DS\Model\Abstracts\AbstractTableRows;

/**
 * Events for model TableRows
 *
 * @see https://docs.phalconphp.com/ar/3.2/db-models-events
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 */
abstract class TableRowsEvents
    extends AbstractTableRows
{
    
    /**
     * @return bool
     */
    public function beforeValidationOnCreate()
    {
        parent::beforeValidationOnCreate();
        
        // Default
        $this->setVotesCount(0);
        
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
}
