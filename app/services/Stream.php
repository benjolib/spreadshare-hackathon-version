<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 15/06/18
 * Time: 8:53
 */

namespace DS\Services;

use DS\Application;
use DS\Model\TableColumns;
use DS\Model\TableContributions;
use DS\Model\TableRelations;
use DS\Model\TableRows;
use DS\Model\Tables;
use DS\Model\TableTags;
use DS\Model\Tags;
use DS\Model\User;
use Phalcon\Http\Request\File;
use Phalcon\Http\Request\FileInterface;

class Stream
{
    const NumberOfRequiredTags = 1;

    /**
     * @param $tagsList
     * @return array
     * @throws \Exception
     */
    public function getTagsIdsAndNames($tagsList): array
    {
        $tagsIds = explode(',', $tagsList);
        if (count($tagsIds) < self::NumberOfRequiredTags) {
            throw new \Exception('Tag missing - Please select at least ' . self::NumberOfRequiredTags . ' tags for your Stream');
        }

        foreach ($tagsIds as $tag) {
            /** @var Tags $t */
            $t = Tags::findFirstById($tag);
            if (empty($t)) {
                throw new \Exception("Tag unknown - Tag $tag doesn't exist");
            }
            $result[] = ['id' => $tag, 'name' => $t->getTitle()];
        }
        return $result;
    }

    /**
     * @param $curatorsList
     * @return array
     * @throws \Exception
     */
    public function getCuratorsIdsAndNames($curatorsList): array
    {
        if (empty($curatorsList)) return [];

        $curatorsIds = explode(',', $curatorsList);
        foreach ($curatorsIds as $curator) {
            $c = User::findFirstById($curator);
            if (empty($c)) {
                //throw new \Exception("Curator unknown - Curator $curator doesn't exist. Make sure you input the correct handle");
                throw new \Exception("Curator unknown - Please check if your team mates user name is correct");
            }
            $result[] = ['id' => $curator, 'name' => $c->getName()];
        }
        return $result;
    }

    /**
     * @param $relatedLists
     * @return array
     * @throws \Exception
     */
    public function getRelatedListsIdsAndTitles($relatedLists): array
    {
        if (empty($relatedLists)) return [];

        $relLists = explode(',', $relatedLists);
        foreach ($relLists as $listId) {
            $l = Tables::findFirstById($listId);
            if (empty($l)) {
                throw new \Exception("List unknown - List doesn't exist");
            }
            $result[] = ['id' => $listId, 'name' => $l->getTitle()];
        }
        return $result;
    }

    /**
     * @param $tableId
     * @param $tagsList
     * @return array
     */
    public function setTags($tableId, $tagsList): array
    {
        $oldTags = TableTags::findAllByFieldValue('tableId', $tableId) ?: [];
        /** @var TableTags $tag */
        foreach ($oldTags as $tag) {
            $tag->delete();
        }

        $tagsIds = $this->getTagsIdsAndNames($tagsList);
        foreach ($tagsIds as $id) {
            $tag = new TableTags();
            $tag->setTableId($tableId)->setTagId($id['id'])->save();
        }
        return $tagsIds;
    }

    /**
     * @param $tableId
     * @param $curatorsList
     * @return array
     */
    public function setCurators($tableId, $curatorsList): array
    {
        $oldCurators = TableContributions::findAllByFieldValue('tableId', $tableId) ?: [];
        /** @var TableContributions $curator */
        foreach ($oldCurators as $curator) {
            $curator->delete();
        }

        if (empty($curatorsList)) {
            return [];
        }

        $ids = $this->getCuratorsIdsAndNames($curatorsList);
        foreach ($ids as $id) {
            $tc = new TableContributions();
            $tc
                ->setTableId($tableId)
                ->setUserId($id['id'])
                ->save();
        }
        return $ids;
    }

    /**
     * @param $tableId
     * @param $relatedLists
     * @return array
     */
    public function setRelatedLists($tableId, $relatedLists): array
    {
        $oldRelatedLists = TableRelations::findAllByFieldValue('tableId', $tableId) ?: [];
        /** @var TableRelations $relatedList */
        foreach ($oldRelatedLists as $relatedList) {
            $relatedList->delete();
        }

        if (empty($relatedLists)) {
            return [];
        }

        $ids = $this->getRelatedListsIdsAndTitles($relatedLists);
        foreach ($ids as $id) {
            $rt = new TableRelations();
            $rt
                ->setTableId($tableId)
                ->setRelatedTableId($id['id'])
                ->save();
        }
        return $ids;
    }

    /**
     * @param $tableId
     * @param $columns
     */
    public function setColumns($tableId, $columns)
    {
        $oldColumns = TableColumns::findAllByFieldValue('tableId', $tableId) ?: [];
        /** @var TableColumns $column */
        foreach ($oldColumns as $column) {
            $column->delete();
        }

        $columns = json_decode($columns, true);
        foreach ($columns as $position => $column) {
            $c = new TableColumns();
            $c->setTableId($tableId)->setTitle($column)->setPosition($position)->save();
        }
    }

    /**
     * @param $tableId
     * @param $rows
     * @param $uploadedFiles
     */
    public function setRows($tableId, $rows, $uploadedFiles)
    {
        $images = [];
        /** @var FileInterface|File $file */
        foreach ($uploadedFiles as $file) {
            if (strpos($file->getKey(), 'listing-image') !== false) {
                $images[$file->getKey()] = $file;
            }
        }

        $decodedRows = json_decode($rows);
        foreach ($decodedRows as $key => $decodedRow) {
            $contentToInsert = '[';
            $rowId = $decodedRow->row->id;
            foreach ($decodedRow->row->content as $content) {
                $contentToInsert .= '{"content":"' . trim(strtok($content,"\n")) . '"},';
            }
            $contentToInsert = rtrim($contentToInsert, ',');
            $contentToInsert .= ']';
            if (empty($rowId)) {
                $row = new TableRows();
            } else {
                $row = TableRows::findFirstById($rowId);
            }
            $row->setTableId($tableId)->setContent($contentToInsert)->save();
            if (!empty($images['listing-image-' . $key])) {
                /** @var FileInterface|File $file */
                $file = $images['listing-image-' . $key];
                $imagePath = '/rowimages/' . $row->getId() . '.' . $file->getExtension();
                $file->moveTo(ROOT_PATH . 'public' . $imagePath);
                $row->setImage($imagePath)->save();
            }
        }
    }

    /**
     * @param int $tableId
     * @return array
     */
    public function getCuratorIdsFromTable(int $tableId):array
    {
        /** @var TableContributions[] $curators */
        $curators = TableContributions::findAllByFieldValue('tableId', $tableId);
        $result = [];
        foreach ($curators as $curator) {
            $result[] = $curator->getUserId();
        }
        return $result;
    }

    /**
     * @param int $tableId
     * @return array
     */
    public function getRelatedListsIdsFromTable(int $tableId):array
    {
        /** @var TableRelations[] $relatedLists */
        $relatedLists = TableRelations::findAllByFieldValue('tableId', $tableId);
        $result = [];
        foreach ($relatedLists as $relatedList) {
            $result[] = $relatedList->getRelatedTableId();
        }
        return $result;
    }

    /**
     * @param int $tableId
     * @return array
     */
    public function getTagsIdsFromTable(int $tableId):array
    {
        /** @var TableTags[] $tags */
        $tags = TableTags::findAllByFieldValue('tableId', $tableId);
        $result = [];
        foreach ($tags as $tag) {
            $result[] = $tag->getTagId();
        }
        return $result;
    }

    /**
     * @param $tableId
     * @param $uploadedFiles
     * @return string
     */
    public function getImagePath($tableId, $uploadedFiles)
    {
        /** @var File $file */
        foreach ($uploadedFiles as $file) {
            if ($file->getKey() == 'image') {
                $imagePath = '/tableimages/'.$tableId.'.'.$file->getExtension();
                $file->moveTo(ROOT_PATH.'public'.$imagePath);
                return $imagePath;
            }
        }
        return "";
    }

    /**
     * @param Tables $table
     */
    public function sendSlackNotification(Tables $table)
    {
        try {
            $config = Application::instance()->getConfig();
            $channel = $config['slack']['streams-channel'];
            $msg = sprintf('New Stream %s (http://%s/stream/%s)',
                $table->getTitle(),
                $config['domain'],
                $table->getSlug()
            );
            serviceManager()->getSlack()->to($channel)->send($msg);
        } catch (\Exception $e) {
            // not that important..
        }
    }
}
