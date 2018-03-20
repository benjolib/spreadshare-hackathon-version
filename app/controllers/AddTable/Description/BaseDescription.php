<?php

namespace DS\Controller\AddTable\Description;

use DS\Api\Table;
use DS\Controller\BaseController;
use DS\Interfaces\TableSubcontrollerInterface;
use DS\Model\DataSource\TableFlags;
use DS\Model\Tables;
use DS\Model\Tools;

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
abstract class BaseDescription extends BaseController implements TableSubcontrollerInterface
{

    /**
     * @param int $userId
     *
     * @return Tables
     */
    protected function prepareModelFromPost(Tables $tableModel, int $userId, $imagePath): Tables
    {
        $topic2Id = $topic1Id = null;

        $topics = $this->request->getPost('topics', null, '');
        if (isset($topics[0])) {
            $topic1Id = $topics[0];
        }
        if (isset($topics[1])) {
            $topic2Id = $topics[1];
        }

        if ($imagePath) {
            $tableModel->setImage($imagePath);
        }

        $tableModel->setTitle((string) $this->request->getPost('title'))
                   ->setSlug((string) $this->request->getPost('slug'))
                   ->setDescription((string) $this->request->getPost('description'))
                   ->setTopic1Id((int) $topic1Id)
                   ->setTopic2Id((int) $topic2Id)
                   ->setTypeId((int) $this->request->getPost('type'))
                   ->setTagline((string) $this->request->getPost('tagline'))
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
        if ($this->request->isPost()) {
            $imagePath = '';
            if ($this->request->hasFiles() == true) {
                foreach ($this->request->getUploadedFiles() as $file) {
                    if ($file->getTempName() && $file->getName() && $file->getSize()) {
                        $imageName = Tools::guidv4(random_bytes(16)) . '.' . $file->getExtension();
                        $file->moveTo(ROOT_PATH . 'system/uploads/listimages/' . $imageName);
                        $imagePath = '/list-images/' . $imageName;
                    }
                }
            }

            $tableApi          = new Table();
            $createdTableModel = $tableApi->createTable(
                $this->prepareModelFromPost(new Tables(), $userId, $imagePath),
                $this->request->getPost('tags', null, []),
                $this->request->getPost('location', null, [])
            );

            return $createdTableModel;
        }

        return null;
    }
}
