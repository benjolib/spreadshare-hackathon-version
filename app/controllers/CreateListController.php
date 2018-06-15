<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;
use DS\Model\DataSource\TableFlags;
use DS\Model\Tables;
use DS\Services\Stream as StreamService;
use Phalcon\Http\Request\File;

class CreateListController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function indexAction()
    {
        $ss = new StreamService();

        $this->view->setMainView('create-list/index');
        $user = $this->serviceManager->getAuth()->getUser();
        $this->view->setVar('post', $this->request->getPost());
        if ($this->request->isPost()) {
            if ($this->request->get('step') == '2') {
                try {
                    $tableId = $this->request->get('tableId');
                    $table = Tables::findFirstById($tableId);
                    $table->setOwnerUserId($user->getId())
                        ->setTitle($this->request->get('name'))
                        ->setTagline($this->request->get('tagline'))
                        ->setDescription($this->request->get('description'));
                    $table->save();
                    try {
                        $ss->setCurators($tableId, $this->request->get('curators'));
                        $ss->setRelatedLists($tableId, $this->request->get('related-lists'));
                        $ss->setTags($tableId, $this->request->get('tags'));
                        $ss->setColumns($tableId, $this->request->get('list-columns'));
                        $ss->setRows($tableId, $this->request->get('list-rows'), $this->request->getUploadedFiles(true));
                        $ss = $this->getImagePath(
                            $user->getId(),
                            $tableId,
                            $this->request->getUploadedFiles(true),
                            $this->request->get('tempImage')
                        );
                        if (!empty($image)) {
                            $table->setImage($image)->save();
                        }
                        $table->setFlags(TableFlags::Published);
                        $table->save();
                    } catch (\Exception $e) {
                        $this->flash->error($e->getMessage());
                        return;
                    }
                } catch (\Exception $e) {
                    $this->flash->error($e->getMessage());
                    return;
                }
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
                    $table = $this->getTable(
                        $user->getId(),
                        $this->request->get('name'),
                        $this->request->get('tagline'),
                        $this->request->get('description')
                    );
                    $table->save();
                    $tableId = $table->getId();

                    $curatorsIdsAndNames = $ss->setCurators($tableId, $this->request->get('curators'));
                    $relatedListsIdsAndNames = $ss->setRelatedLists($tableId, $this->request->get('related-lists'));
                    $tagsIdsAndNames = $ss->setTags($tableId, $this->request->get('tags'));

                    $this->view->setVar('tags', empty($tagsIdsAndNames)?[]:array_column($tagsIdsAndNames, 'id'));
                    $this->view->setVar('tagsNames', empty($tagsIdsAndNames)?[]:array_column($tagsIdsAndNames, 'name'));
                    $this->view->setVar('curators', empty($curatorsIdsAndNames)?[]:array_column($curatorsIdsAndNames, 'id'));
                    $this->view->setVar('curatorsNames', empty($curatorsIdsAndNames)?[]:array_column($curatorsIdsAndNames, 'name'));
                    $this->view->setVar('related-lists', empty($relatedListsIdsAndNames)?[]:array_column($relatedListsIdsAndNames, 'id'));
                    $this->view->setVar('related-listsNames', empty($relatedListsIdsAndNames)?[]:array_column($relatedListsIdsAndNames, 'name'));


                    $tableContentFromCsv = $this->tableContentFromCsv($csv);
                    $this->view->setVar('tableId', $tableId);
                    $this->view->setVar('tableColumns', $tableContentFromCsv[0]);
                    $this->view->setVar('tableContent', array_splice($tableContentFromCsv, 1));
                } catch (\Exception $e) {
                    if (!empty($table)) $table->delete();
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

    protected function getTable($userId, $name,$tagline, $description)
    {
        try {
            $table = new Tables();
            $table->setOwnerUserId($userId)
                ->setTitle($name)
                ->setTagline($tagline)
                ->setDescription($description);
            return $table;
        } catch (\Exception $e) {
            throw new \Exception('Error on table data - ' . $e->getMessage());
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
