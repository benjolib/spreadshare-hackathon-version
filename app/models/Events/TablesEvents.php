<?php

namespace DS\Model\Events;

use AlgoliaSearch\AlgoliaException;
use DS\Events\Table\TableCreated;
use DS\Events\Table\TableUpdated;
use DS\Model\Abstracts\AbstractTables;
use DS\Model\DataSource\TableFlags;
use DS\Model\Tables;
use DS\Model\TableStats;
use DS\Model\Types;

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
abstract class TablesEvents extends AbstractTables
{
    /**
     * Algolia index name. Environment is appended
     */
    const ALGOLIA_INDEX = 'spreadshare-stream';
    
    /**
     * Push current instance to Algolia
     */
    private function pushToAlgolia()
    {
        try {
            $index = $this->serviceManager->getAlgolia()->initIndex(self::ALGOLIA_INDEX . '-' . ENV);
            $index->addObjects([[
                        'objectID'    => $this->getId(),
                        'title'       => $this->getTitle(),
                        'tagline'     => $this->getTagline(),
                        'description' => $this->getDescription(),
                        'tags'        => implode(' ', $this->getTagsTitles()),      // search by tag titles
                        'bundles'     => implode(' ', $this->getBundlesTitles()),   // search by bundle titles
            ]]);
        } catch (AlgoliaException $e) {
            $this->serviceManager->getRavenClient()->captureException($e);
        }
    }
    
    /**
     * Remove object from algolia index
     */
    private function removeFromAlgolia()
    {
        try {
            $index = $this->serviceManager->getAlgolia()->initIndex(self::ALGOLIA_INDEX . '-' . ENV);
            $index->deleteObject($this->getId());
        } catch (\Exception $e) {
            $this->serviceManager->getRavenClient()->captureException($e);
        }
    }
    
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
        
        if (!empty($this->getTitle())) {
            if (strlen($this->getTitle()) < 4) {
                throw new \InvalidArgumentException('Please provide at least four characters for the table name.');
            }
            
            // Check if table with this name already exists
            $tableCheck = Tables::findByFieldValue('title', $this->getTitle());
            if ($tableCheck && $tableCheck->getId() != $this->getId()) {
                throw new \InvalidArgumentException('A table with the exact same title already exists. Please choose another title');
            }
        }
        
        if (!$this->getTypeId()) {
            $this->setTypeId(null);
        }

//        if (!$this->getTopic1Id())
//        {
//            throw new \InvalidArgumentException('Please select at least one topic for your table.');
//        }
//
//        if (!$this->getTopic2Id())
//        {
//            $this->setTopic2Id(null);
//        }
        
        if ($this->getTypeId() && Types::findFirstById($this->getTypeId()) === false) {
            throw new \InvalidArgumentException("Your selected type is invalid. Please select another one.");
        }
        
        if (!$this->getFlags()) {
            $this->setFlags(TableFlags::Unpublished);
        }
        
        if (!$this->getSlug() && strpos($this->getTitle(), "temptitle") === false) {
            $slug      = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->getTitle())));
            $slugCheck = Tables::findByFieldValue('slug', $slug);
            $i         = 2;
            while ($slugCheck && $slugCheck->getId() != $this->getId()) {
                $slug      = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->getTitle()))) . '_' . $i;
                $slugCheck = Tables::findByFieldValue('slug', $slug);
                $i++;
            }
            $this->setSlug($slug);
        }
        
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
        
        if ($this instanceof Tables) {
            TableCreated::after($this->getOwnerUserId(), $this);
        }
        
        return true;
    }
    
    /**
     * @return bool
     */
    public function afterSave()
    {
        if ($this instanceof Tables) {
            TableUpdated::after($this->getOwnerUserId(), $this);
            
            if ($this->getFlags() === TableFlags::Published) {
                $this->pushToAlgolia();
            }
            
            if ($this->getFlags() === TableFlags::Unpublished) {
                $this->removeFromAlgolia();
            }
        }
        
        return true;
    }

    /**
     *
     */
    public function afterDelete()
    {
        $this->removeFromAlgolia();
    }
}
