<?php

namespace DS\Model;

use Phalcon\Mvc\Model;

/**
 * Spreadshare
 *
 * Some default events
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
abstract class BaseEvents extends Model
{
    /**
     * @return bool
     */
    public function beforeValidationOnCreate()
    {
        $time = time();
        if (property_exists($this, 'updatedAt')) {
            $this->updatedAt = $time;
        }
        
        if (property_exists($this, 'updatedById')) {
            $this->updatedById = auth()->getUserId();
        }
        
        if (property_exists($this, 'createdAt')) {
            $this->createdAt = $time;
        }
        
        return true;
    }
    
    /**
     * @return bool
     */
    public function beforeValidationOnUpdate()
    {
        if (property_exists($this, 'updatedAt')) {
            $this->updatedAt = time();
        }
        
        if (property_exists($this, 'updatedById')) {
            $this->updatedById = auth()->getUserId();
        }
        
        return true;
    }
}
