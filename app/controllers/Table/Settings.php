<?php

namespace DS\Controller\Table;

use DS\Controller\BaseController;
use DS\Interfaces\TableSubcontrollerInterface;
use DS\Model\Helper\TableFilter;
use DS\Model\TableLocations;
use DS\Model\Tables;
use DS\Model\TableTags;
use DS\Model\Tags;
use Phalcon\Acl\Exception;

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
            $tableModel = new Tables();
            $tables     = $tableModel->findTablesAsArray($userId, new TableFilter(), 0);
            if (!count($tables))
            {
                throw new \InvalidArgumentException('Table does not exist.');
            }

            if ($table[0]['ownerUserId'] != $userId)
            {
                throw new Exception('You are not allowed to edit the settings of this table.');
            }

            $this->view->setVar('table', $table[0]);

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

            $this->view->setMainView('table/detail/changelog');
            $this->view->setVar('selectedPage', 'changelog');
        }
        catch (\Exception $e)
        {
            throw $e;
        }

        return $this;
    }
}