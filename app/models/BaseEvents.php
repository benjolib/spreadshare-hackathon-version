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
abstract class BaseEvents
    extends Model
{
    /**
     * @return bool
     */
    public function beforeCreate()
    {
        $time = time();
        if (isset($this->lastUpdateAt))
        {
            $this->lastUpdateAt = $time;
        }
        
        if (isset($this->createdAt))
        {
            $this->createdAt = $time;
        }
        
        return true;
    }
    
    /**
     * @return bool
     */
    public function beforeSave()
    {
        if (isset($this->lastUpdateAt))
        {
            $this->lastUpdateAt = time();
        }
        
        return true;
    }
}