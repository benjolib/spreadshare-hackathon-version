<?php

namespace DS\Api;

use DS\Model\DataSource\TableFlags;
use DS\Model\TableLocations;
use DS\Model\Tables;
use DS\Model\TableTags;
use Phalcon\Exception;

/**
 * Spreadshare
 *
 * General Users Api
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
class Table
    extends BaseApi
{
    
    /**
     * @param int $tableId
     *
     * @return Tables
     */
    public function publish(int $tableId)
    {
        $tableModel = Tables::get($tableId);
        $tableModel->setFlags(TableFlags::Published)->save();
        
        return $tableModel;
    }
    
    /**
     * Searches a table by name
     *
     * @param string $name
     * @param int    $limit
     *
     * @return array
     */
    public static function searchTableByName(string $name, int $limit = 100)
    {
        $locations = new Tables();
        
        return $locations->find(
            [
                "conditions" => "title LIKE ?0",
                'columns' => ['id', 'title'],
                "order" => "title ASC",
                "limit" => $limit,
                "bind" => ['%' . $name . '%'],
            ]
        )->toArray();
    }
    
    public function saveTable(
        int $tableId,
        int $ownerUserId,
        string $title,
        string $tagline,
        string $image,
        int $typeId = null,
        int $topic1Id = null,
        int $topic2Id = null,
        array $tags = [],
        array $locations = [],
        int $flags = TableFlags::Normal
    ) {
    
    }
    
    /**
     * Create a table
     *
     * @param Tables $preparedTableModel
     * @param array  $tags
     * @param array  $locations
     *
     * @return Tables
     * @throws Exception
     */
    public function createTable(
        Tables $preparedTableModel,
        array $tags = [],
        array $locations = []
    ) {
        
        // Create table entry
        $preparedTableModel->create();
        
        if (!$preparedTableModel->getId())
        {
            throw new Exception('There was an error creating the table. Please try again later or contact our support.');
        }
        
        $this->handleTagAndLocationAssignment($preparedTableModel, $tags, $locations);
        
        return $preparedTableModel;
    }
    
    /**
     * @param Tables $preparedTableModel
     * @param array  $tags
     * @param array  $locations
     */
    public function handleTagAndLocationAssignment(Tables $preparedTableModel, array $tags = [], array $locations = [])
    {
        // Add tags to table
        (new TableTags())->clear($preparedTableModel->getId());
        foreach ($tags as $tag)
        {
            try
            {
                $tagsModel = new TableTags();
                $tagsModel->setTableId($preparedTableModel->getId())
                          ->setTagId($tag)
                          ->create();
            }
            catch (\Exception $e)
            {
                // Tag id may not existing..?
            }
        }
        
        // Add locations to table
        (new TableLocations())->clear($preparedTableModel->getId());
        foreach ($locations as $location)
        {
            try
            {
                $locationModel = new TableLocations();
                $locationModel->setTableId($preparedTableModel->getId())
                              ->setLocationId($location)
                              ->create();
            }
            catch (\Exception $e)
            {
                // Location id may not existing..?
            }
        }
    }
}