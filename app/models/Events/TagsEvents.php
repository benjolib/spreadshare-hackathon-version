<?php

namespace DS\Model\Events;

use DS\Model\Abstracts\AbstractTags;
use DS\Model\Tags;

/**
 * Events for model Tags
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
abstract class TagsEvents
    extends AbstractTags
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

        if (!$this->getSlug() && strpos($this->getTitle(), "temptitle") === false)
        {
            $slug      = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->getTitle())));
            $slugCheck = Tags::findByFieldValue('slug', $slug);
            $i         = 2;
            while ($slugCheck && $slugCheck->getId() != $this->getId())
            {
                $slug      = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->getTitle()))) . '_' . $i;
                $slugCheck = Tags::findByFieldValue('slug', $slug);
                $i++;
            }
            $this->setSlug($slug);
        }

        return true;
    }
}
