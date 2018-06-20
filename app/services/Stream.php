<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 15/06/18
 * Time: 8:53
 */

namespace DS\Services;

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
    public function getTagsIdsAndNames($tagsList): array
    {
        $tagsIds = explode(',', $tagsList);
        if (count($tagsIds) < 3) {
            throw new \Exception('Tag missing - Please select at least 3 tags for your Stream');
        }
        foreach ($tagsIds as $tag) {
            /** @var Tags $t */
            $t = Tags::findFirstById($tag);
            if (empty($t)) {
                throw new \Exception("Error in tags - Tag $tag doesn't exist");
            }
            $result[] = ['id' => $tag, 'name' => $t->getTitle()];
        }
        return $result;
    }

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

    public function setCurators($tableId, $curatorsList): array
    {
        $oldCurators = TableContributions::findAllByFieldValue('tableId', $tableId) ?: [];
        /** @var TableContributions $curator */
        foreach ($oldCurators as $curator) {
            $curator->delete();
        }

        if (empty($curatorsList)) return [];

        $ids = $this->getCuratorsIdsAndNames($curatorsList);
        foreach ($ids as $id) {
            $tc = new TableContributions();
            $tc->setTableId($tableId)->setUserId($id['id'])->save();
        }
        return $ids;
    }

    public function setRelatedLists($tableId, $relatedLists): array
    {
        $oldRelatedLists = TableRelations::findAllByFieldValue('tableId', $tableId) ?: [];
        /** @var TableRelations $relatedList */
        foreach ($oldRelatedLists as $relatedList) {
            $relatedList->delete();
        }

        if (empty($relatedLists)) return [];

        $ids = $this->getRelatedListsIdsAndTitles($relatedLists);
        foreach ($ids as $id) {
            $rt = new TableRelations();
            $rt->setTableId($tableId)->setRelatedTableId($id['id'])->save();
        }
        return $ids;
    }

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
                $contentToInsert .= '{"content":"' . $content . '"},';
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

    public function getImagePath($tableId, $uploadedfiles)
    {
        /** @var File $file */
        foreach($uploadedfiles as $file) {
            if ($file->getKey() =='image') {
                $imagePath = '/tableimages/'.$tableId.'.'.$file->getExtension();
                $file->moveTo(ROOT_PATH.'public'.$imagePath);
                return $imagePath;
            }
        }
        return "";
    }
}