<?php

namespace DS\Controller\AddTable\Description;

use DS\Api\Table;
use DS\Controller\BaseController;
use DS\Interfaces\TableSubcontrollerInterface;
use DS\Model\DataSource\TableFlags;
use DS\Model\Tables;

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
abstract class BaseDescription
    extends BaseController
    implements TableSubcontrollerInterface
{
    
    /**
     * @param int $userId
     *
     * @return Tables
     */
    protected function prepareModelFromPost(Tables $tableModel, int $userId): Tables
    {
        $topic2Id = $topic1Id = null;
        
        $topics = $this->request->getPost('topics', null, '');
        if (isset($topics[0]))
        {
            $topic1Id = $topics[0];
        }
        if (isset($topics[1]))
        {
            $topic2Id = $topics[1];
        }
        
        $tableModel->setTitle((string) $this->request->getPost('title', null, ''))
                   ->setTopic1Id((int) $topic1Id)
                   ->setTopic2Id((int) $topic2Id)
                   ->setTypeId((int) $this->request->getPost('type'))
                   ->setImage((string) $this->request->getPost('image', '', ''))
                   ->setTagline((string) $this->request->getPost('tagline', null, ''))
                   ->setFlags(TableFlags::Unpublished)
                   ->setOwnerUserId($userId);
        
        return $tableModel;
    }
    
    /**
     * @param int $userId
     *
     * @return \DS\Model\Tables|static
     */
    protected function handlePost(int $userId, int $tableId = 0)
    {
        if ($this->request->isPost())
        {
            $tableApi          = new Table();
            $createdTableModel = $tableApi->createTable(
                $this->prepareModelFromPost(new Tables(), $userId),
                $this->request->getPost('tags', null, []),
                $this->request->getPost('location', null, [])
            );
            
            return $createdTableModel;
        }
        
        return null;
    }
    
}