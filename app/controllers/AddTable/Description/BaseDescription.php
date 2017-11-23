<?php

namespace DS\Controller\AddTable\Description;

use DS\Api\Table;
use DS\Controller\BaseController;
use DS\Interfaces\TableSubcontrollerInterface;

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
     * @return \DS\Model\Tables|static
     */
    protected function handlePost(int $userId)
    {
        if ($this->request->isPost())
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
            
            $tableApi          = new Table();
            $createdTableModel = $tableApi->createTable(
                $userId,
                (string) $this->request->getPost('title', null, ''),
                (string) $this->request->getPost('tagline', null, ''),
                (string) $this->request->getPost('image', '', '/assets/images/dustin.jpg'),
                (int) $this->request->getPost('type'),
                (int) $topic1Id,
                (int) $topic2Id,
                $this->request->getPost('tags', null, []),
                $this->request->getPost('location', null, [])
            );
            
            return $createdTableModel;
        }
        
        return null;
    }
    
}