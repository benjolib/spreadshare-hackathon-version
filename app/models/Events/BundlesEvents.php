<?php

namespace DS\Model\Events;

use DS\Model\Abstracts\AbstractBundles;

/**
 * Events for model Bundles
 *
 * @see       https://docs.phalconphp.com/ar/3.2/db-models-events
 *
 * @author    Vladislav Klimenko
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 */
abstract class BundlesEvents extends AbstractBundles
{
    /**
     * @return bool
     */
    public function beforeValidationOnCreate()
    {
        return parent::beforeValidationOnCreate();
    }
    
    /**
     * @return bool
     */
    public function beforeValidationOnUpdate()
    {
        parent::beforeValidationOnUpdate();

        if (strlen($this->getTitle()) < 4) {
            throw new \InvalidArgumentException('Please provide at least four characters for the title.');
        }

        // Check if bundle with this name already exists
        $bundle = self::findByFieldValue('title', $this->getTitle());
        if ($bundle && $bundle->getId() != $this->getId()) {
            throw new \InvalidArgumentException('A bundle with the exact same title already exists. Please choose another title');
        }

        return true;
    }
    
    /**
     * @return bool
     */
    public function afterCreate()
    {
        return true;
    }
    
    /**
     * @return bool
     */
    public function afterSave()
    {
        return true;
    }

    /**
     *
     */
    public function afterDelete()
    {
    }
}
