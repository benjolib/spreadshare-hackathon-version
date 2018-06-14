<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;
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

class CreateListController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function indexAction()
    {
        $this->view->setMainView('create-list/index');
        $user = $this->serviceManager->getAuth()->getUser();
        $this->view->setVar('post', $this->request->getPost());
        if ($this->request->isPost()) {
            if ($this->request->get('step') == '2') {
                try {
                    $table = $this->getTable(
                        $user->getId(),
                        $this->request->get('name'),
                        $this->request->get('description')
                    );
                    $table->save();
                    $tableId = $table->getId();
                    try {
                        $this->setCurators($tableId, $this->request->get('curators'));
                        $this->setRelatedLists($tableId, $this->request->get('related-lists'));
                        $this->setTags($tableId, $this->request->get('tags'));
                        $this->setColumns($tableId, $this->request->get('list-columns'));
                        $this->setRows($tableId, $this->request->get('list-rows'), $this->request->getUploadedFiles(true));
                        $image = $this->getImagePath(
                            $user->getId(),
                            $tableId,
                            $this->request->getUploadedFiles(true),
                            $this->request->get('tempImage')
                        );
                        if (!empty($image)) {
                            $table->setImage($image)->save();
                        }
                    } catch (\Exception $e) {
                        $table->delete();
                        $this->flash->error($e->getMessage());
                        return;
                    }
                } catch (\Exception $e) {
                    $this->flash->error($e->getMessage());
                    return;
                }
//                var_dump("tableId$tableId");
//                foreach ($this->request->getUploadedFiles() as $key => $uploadedFile) {
//                    var_dump($key);
//                    var_dump($uploadedFile);
//                }
//                var_dump($this->request->getPost());
//                die();
                $this->response->redirect("/list/" . $tableId, true);

            } else {
                $csv = $this->request->get('copy');

                if ($this->request->hasFiles(true)) {
                    foreach ($this->request->getUploadedFiles(true) as $key => $uploadedFile) {
                        switch ($uploadedFile->getKey()) {
                            case 'file':
                                $csv = file_get_contents($uploadedFile->getTempName());
                                break;
                            case 'image':
                                $imageName = 'tmpTableImg-'.$user->getId() . '.' . $uploadedFile->getExtension();
                                $imagePath = 'temptableimages/' . $imageName;
                                $uploadedFile->moveTo(ROOT_PATH . 'public/' . $imagePath);
                                $this->view->setVar('tempImage', $imageName);
                                break;
                        }
                    }
                }
                try {
                    $tableContentFromCsv = $this->tableContentFromCsv($csv);
                    $this->view->setVar('tableColumns', $tableContentFromCsv[0]);
                    $this->view->setVar('tableContent', array_splice($tableContentFromCsv, 1));
                } catch (\Exception $e) {
                    $this->flash->error($e->getMessage());
                    return;
                }
                try {
                    $table = $this->getTable(
                        $user->getId(),
                        $this->request->get('name'),
                        $this->request->get('description')
                    );
                    $this->getTagsIds($this->request->get('tags'));
                    $this->getCuratorsIds($this->request->get('curators'));
                    $this->getRelatedListsIds($this->request->get('related-lists'));
                } catch (\Exception $e) {
                    $this->flash->error($e->getMessage());
                    return;
                }

            }
        }


        $this->view->setVar('editing', true);
    }

    protected function tableContentFromCsv($csv): array
    {
        $newlineSeparator = "\r\n";
        $colSeparator = ',';
        $tableColumns = explode($colSeparator, strtok($csv, $newlineSeparator));
        $numColumns = count($tableColumns);

        $line = strtok($newlineSeparator);
        $tableContent[] = $tableColumns;
        $rowNumber = 1;
        while ($line !== false) {
            $row = explode($colSeparator, $line);
            if (count($row) !== $numColumns) {
                throw new \Exception("Wrong number of columns - The row $rowNumber has a different number of columns");
            }
            $tableContent[] = $row;
            $line = strtok($newlineSeparator);
            $rowNumber++;
        }
        return $tableContent;
    }

    protected function getTable($userId, $name, $description)
    {
        try {
            $table = new Tables();
            $table->setOwnerUserId($userId)
                ->setTitle($name)
                ->setTagline($description);
            return $table;
        } catch (\Exception $e) {
            throw new \Exception('Error on table data - ' . $e->getMessage());
        }
    }

    protected function getTagsIds($tagsList): array
    {
        $tagsIds = explode(',', $tagsList);
        if (count($tagsIds) < 3) {
            throw new \Exception('Error in tags - you should add at least three tags (separated by commas)');
        }
        foreach ($tagsIds as $tag) {
            $t = Tags::findFirstById($tag);
            if (empty($t)) {
                throw new \Exception("Error in tags - Tag $tag doesn't exist");
            }
        }
        return $tagsIds;
    }

    protected function getCuratorsIds($curatorsList): array
    {
        if (empty($curatorsList)) return [];

        $curatorsIds = explode(',', $curatorsList);
        foreach ($curatorsIds as $curator) {
            $c = User::findFirstById($curator);
            if (empty($c)) {
                throw new \Exception("Error in curators - Curator $curator doesn't exist. Make sure you input the correct handle");
            }
        }
        return $curatorsIds;
    }

    protected function getRelatedListsIds($relatedLists): array
    {
        if (empty($relatedLists)) return [];

        $relLists = explode(',', $relatedLists);
        foreach ($relLists as $listId) {
            $l = Tables::findFirstById($listId);
            if (empty($l)) {
                throw new \Exception("Error in related lists - List with id $listId doesn't exist");
            }
        }
        return $relLists;
    }

    protected function setTags($tableId, $tagsList)
    {
        $tagsIds = $this->getTagsIds($tagsList);
        foreach ($tagsIds as $id) {
            $tag = new TableTags();
            $tag->setTableId($tableId)->setTagId($id)->save();
        }
    }

    protected function setCurators($tableId, $curatorsList)
    {
        if (empty($curatorsList)) return;

        $ids = $this->getCuratorsIds($curatorsList);
        foreach ($ids as $id) {
            $tc = new TableContributions();
            $tc->setTableId($tableId)->setUserId($id)->save();
        }
    }

    protected function setRelatedLists($tableId, $relatedLists)
    {
        if (empty($relatedLists)) return;

        $ids = $this->getRelatedListsIds($relatedLists);
        foreach ($ids as $id) {
            $rt = new TableRelations();
            $rt->setTableId($tableId)->setRelatedTableId($id)->save();
        }
    }

    protected function setColumns($tableId, $columns)
    {
        $columns = json_decode($columns, true);
        foreach ($columns as $position => $column) {
            $c = new TableColumns();
            $c->setTableId($tableId)->setTitle($column)->setPosition($position)->save();
        }
    }

    protected function setRows($tableId, $rows, $uploadedFiles)
    {
        $images = [];
        foreach ($uploadedFiles as $file) {
            if (strpos($file->getKey(), 'listing-image') !== false) {
                $images[$file->getKey()] = $file;
            }
        }
        $decodedRows = json_decode($rows);
        foreach($decodedRows as $key => $decodedRow) {
            $contentToInsert = '[';
            foreach($decodedRow->content as $content) {
                   $contentToInsert .= '{"content":"'.$content.'"},';
            }
            $contentToInsert = rtrim($contentToInsert,',');
            $contentToInsert .= ']';
            $row = new TableRows();
            $row->setTableId($tableId)->setContent($contentToInsert)->save();
            if (!empty($images['listing-image-'.$key])) {
                /** @var FileInterface|File $file */
                $file = $images['listing-image-'.$key];
                $imagePath = '/rowimages/'.$row->getId().'.'.$file->getExtension();
                $file->moveTo(ROOT_PATH.'public'.$imagePath);
                $row->setImage($imagePath)->save();
            }
        }
    }

    protected function getImagePath($userId, $tableId, $uploadedfiles, $tempImage)
    {
        /** @var File $file */
        foreach($uploadedfiles as $file) {
            if ($file->getKey() =='image') {
                $imagePath = 'tableimages/'.$tableId.'.'.$file->getExtension();
                $file->moveTo(ROOT_PATH.'public/'.$imagePath);
                return $imagePath;
            }
        }
        if (!empty($tempImage)) {
            $fileUserId = substr(
                $tempImage,
                strrpos($tempImage, '-')+1,
                strrpos($tempImage, '-')-strrpos($tempImage,'.')-1);
            if ($fileUserId != $userId) {
                var_dump($fileUserId);
                var_dump($userId);
                throw new \Exception("Error with image - temporary image doesn't match user id");
            }
            $fileExtension = substr($tempImage, strrpos($tempImage, '.'));

            $imagePath = '/tableimages/' . $tableId . $fileExtension;
            rename(
                ROOT_PATH.'public/temptableimages/'.$tempImage,
                ROOT_PATH . 'public' . $imagePath
            );
            return $imagePath;
        }
        return "";
    }
}
