<?php

namespace DS\Controller\Table;

use DS\Controller\AddTable\Description\BaseDescription;
use DS\Exceptions\SecurityException;
use DS\Interfaces\TableSubcontrollerInterface;
use DS\Model\DataSource\TableFlags;
use DS\Model\Helper\TableFilter;
use DS\Model\Locations;
use DS\Model\TableLocations;
use DS\Model\TableProperties;
use DS\Model\TableRelations;
use DS\Model\Tables;
use DS\Model\TableTags;
use DS\Model\Tags;
use Symfony\Component\VarDumper\VarDumper;

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
    extends BaseDescription
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
    public function handle(Tables $table, int $userId, string $tab, string $param)
    {
        try
        {
            if ($table->getOwnerUserId() != $userId)
            {
                throw new SecurityException('You are not allowed to edit the settings of this table.');
            }
            
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
                        
                        if ($tableId == $table->getId())
                        {
                            throw new \InvalidArgumentException('You cannot add a relation to the same table.');
                        }
                        
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
                    $tableProps = (new TableProperties())->get($table->getId(), 'tableId');
                    
                    if ($this->request->isPost())
                    {
                        try
                        {
                            if ($this->request->getPost('action') === 'delete')
                            {
                                $table->setFlags(TableFlags::Deleted)->save();
                                
                                header('Location: /?msg=1');
                            }
                            else
                            {
                                $this->prepareModelFromPost($table, $userId)->save();
                                
                                $tableApi = new \DS\Api\Table();
                                $tableApi->handleTagAndLocationAssignment(
                                    $table,
                                    $this->request->getPost('tags', null, []),
                                    $this->request->getPost('location', null, [])
                                );
                                
                                $tableApi->fixRowsAndColumns(
                                    $table->getId(),
                                    (int) $this->request->getPost('fixedRowsTop', null, 0),
                                    (int) $this->request->getPost('fixedColumnsLeft', null, 0)
                                );
                            }
                        }
                        catch (\Exception $e)
                        {
                            $this->flash->error($e->getMessage());
                        }
                    }
                    
                    $tableModel = new Tables();
                    $tables     = $tableModel->findTablesAsArray($userId, (new TableFilter())->setTableIds([$table->getId()]), 0);
                    if (!count($tables))
                    {
                        throw new \InvalidArgumentException('Table does not exist.');
                    }
                    $loadedTable = $tables[0];
                    
                    $this->view->setVar('table', $loadedTable);
                    
                    $tags = [];
                    foreach (TableTags::findAllByFieldValue('tableId', $table->getId()) as $tag)
                    {
                        $tagModel = Tags::get($tag->getTagId());
                        $tags[]   = $tagModel->toArray(['id', 'title']);
                    }
                    $this->view->setVar('tags', $tags);
                    
                    $locations = [];
                    foreach (TableLocations::findAllByFieldValue('tableId', $table->getId()) as $location)
                    {
                        $locationModel = Locations::get($location->getLocationId());
                        $locations[]   = $locationModel->toArray(['id', 'locationName']);
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
                    $this->view->setVar('tableProps', $tableProps);
                    break;
            }
            
            $this->view->setMainView('table/detail/settings');
            $this->view->setVar('selectedPage', 'settings');
        }
        catch (\Exception $e)
        {
            throw $e;
        }
        
        return $this;
    }
}