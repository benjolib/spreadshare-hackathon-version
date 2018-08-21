<?php

namespace DS\Model\Events;

use DS\Model\Abstracts\AbstractBundleTags;

/**
 * Events for model BundleTags
 *
 * @see https://docs.phalconphp.com/ar/3.2/db-models-events
 *
 * @author    Vladislav Klimenko
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 */
abstract class BundleTagsEvents extends AbstractBundleTags
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
}
