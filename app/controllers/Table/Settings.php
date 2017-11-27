<?php

namespace DS\Controller\Table;

use DS\Controller\BaseController;
use DS\Exceptions\SecurityException;
use DS\Interfaces\TableSubcontrollerInterface;
use DS\Model\Helper\TableFilter;
use DS\Model\TableLocations;
use DS\Model\TableRelations;
use DS\Model\Tables;
use DS\Model\TableTags;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller\User
 */
class Settings
    extends BaseController
    implements TableSubcontrollerInterface
{
    
    /**
     * Handle Subcontroller
     *
     * @param Tables $table
     * @param int    $userId
     *
     * @return $this
     */
    public function handle(Tables $table, int $userId, string $param)
    {
        try
        {
            if ($table->getOwnerUserId() != $userId)
            {
                throw new SecurityException('You are not allowed to edit the settings of this table.');
            }
            $tableModel = new Tables();
            $tables     = $tableModel->findTablesAsArray($userId, new TableFilter(), 0);
            if (!count($tables))
            {
                throw new \InvalidArgumentException('Table does not exist.');
            }
            $loadedTable = $tables[0];
            
            if (!$param)
            {
                $param = 'details';
            }
            $this->view->setVar('page', $param);
            
            switch ($param)
            {
                case "related":
                    $relatedTables = new TableRelations();
                    if ($this->request->isPost())
                    {
                        $tableId = $this->request->getPost('tableId');
                        if ($tableId)
                        {
                            if (!TableRelations::findRelatedTable($table->getId(), $tableId))
                            {
                                $relatedTables->setTableId($table->getId())
                                              ->setRelatedTableId($tableId)
                                              ->create();
                            }
                        }
                    }
                    
                    $this->view->setVar('relatedTables', $relatedTables->findRelatedTables($table->getId()));
                    break;
                
                default:
                case 'details':
                    $this->view->setVar('table', $loadedTable);
                    
                    $tags = [];
                    foreach (TableTags::findByFieldValue('tableId', $table->getId()) as $tag)
                    {
                        $tags[] = [
                            'id' => $tag->getId(),
                            'title' => $tag->getTitle(),
                        ];
                    }
                    
                    $this->view->setVar('tags', $tags);
                    
                    $locations = [];
                    foreach (TableLocations::findByFieldValue('tableId', $table->getId()) as $location)
                    {
                        $locations[] = [
                            'id' => $location->getId(),
                            'locationName' => $location->getTitle(),
                        ];
                    }
                    $this->view->setVar('locations', $locations);
                    
                    $topics = [];
                    if ($loadedTable['topic1Id'])
                    {
                        $topics[] = [
                            'value' => $loadedTable['topic1Id'],
                            'label' => $loadedTable['topic1'],
                        ];
                    }
                    if ($loadedTable['topic2Id'])
                    {
                        $topics[] = [
                            'value' => $loadedTable['topic2Id'],
                            'label' => $loadedTable['topic2'],
                        ];
                    }
                    
                    $this->view->setVar('topics', $topics);
                    break;
            }
            
            $this->view->setMainView('table/detail/settings');
            $this->view->setVar('selectedPage', 'changelog');
        }
        catch (\Exception $e)
        {
            throw $e;
        }
        
        return $this;
    }
}