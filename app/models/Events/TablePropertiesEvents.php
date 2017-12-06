<?php

namespace DS\Model\Events;

use DS\Model\Abstracts\AbstractTableProperties;

/**
 * Events for model TableProperties
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
abstract class TablePropertiesEvents
    extends AbstractTableProperties
{
    
    /**
     * @return bool
     */
    public function beforeValidationOnCreate()
    {
        parent::beforeValidationOnCreate();
        
        if (!$this->getTableId())
        {
            throw new \InvalidArgumentException('Invalid table id.');
        }
        
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
     * After Save
     */
    public function afterSave()
    {
    
    }
}
