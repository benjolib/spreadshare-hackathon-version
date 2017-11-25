<?php

namespace DS\Model\Helper;

/**
 * Spreadshare
 *
 * Table Filter Model
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 */
class TableFilter
{
    /**
     * @var string
     */
    public $topic = '';
    
    /**
     * @var string
     */
    public $type = '';
    
    /**
     * @var array
     */
    public $tags = [];
    
    /**
     * @var array
     */
    public $locations = [];
    
    /**
     * @var array
     */
    public $tableIds = [];
    
    /**
     * @param int $tableId
     *
     * @return TableFilter
     */
    public function addTableId(int $tableId): TableFilter
    {
        $this->tableIds[] = $tableId;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getTopic(): string
    {
        return $this->topic;
    }
    
    /**
     * @param string $topic
     *
     * @return $this
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
    
    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        
        return $this;
    }
    
    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }
    
    /**
     * @param array $tags
     *
     * @return $this
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        
        return $this;
    }
    
    /**
     * @return array
     */
    public function getLocations(): array
    {
        return $this->locations;
    }
    
    /**
     * @param array $locations
     *
     * @return $this
     */
    public function setLocations($locations)
    {
        $this->locations = $locations;
        
        return $this;
    }
    
    /**
     * @return array
     */
    public function getTableIds(): array
    {
        return $this->tableIds;
    }
    
    /**
     * @param array $tableIds
     *
     * @return $this
     */
    public function setTableIds($tableIds)
    {
        $this->tableIds = $tableIds;
        
        return $this;
    }
}
