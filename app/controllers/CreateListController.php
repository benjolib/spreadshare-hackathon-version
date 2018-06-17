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
        $this->view->setVar('editing', true);
        $user = $this->serviceManager->getAuth()->getUser();
         

        if ($this->request->isPost()) {
        // convert strings to arrays from post
        $post = $this->request->getPost();
        $post['related-lists'] = explode(",",$this->request->getPost()['related-lists']);
        $post['curators'] = explode(",", $this->request->getPost()['curators']);
        $post['tags'] = explode(",",$this->request->getPost()['tags']);
        $this->view->setVar('post', $post);
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
                        $image = $ss->getImagePath(
                            $tableId,
                            $this->request->getUploadedFiles(true)
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
                try {
                    if (!empty($this->request->getPost('tableId'))) {
                        $table = Tables::findFirstById($this->request->getPost('tableId'));
                    } else {
                        $table = $this->getTable(
                            $user->getId(),
                            $this->request->get('name'),
                            $this->request->get('tagline'),
                            $this->request->get('description')
                        );
                        $table->save();
                    }
                    $tableId = $table->getId();
                    $this->view->setVar('tableId', $tableId);

                    $csv = $this->request->get('copy');

                    if ($this->request->hasFiles(true)) {
                        foreach ($this->request->getUploadedFiles(true) as $key => $uploadedFile) {
                            switch ($uploadedFile->getKey()) {
                                case 'file':
                                    $csv = file_get_contents($uploadedFile->getTempName());
                                    break;
                            }
                        }
                    }

                    $image = $ss->getImagePath(
                        $tableId,
                        $this->request->getUploadedFiles(true)
                    );
                    if (!empty($image)) {
                        $table->setImage($image)->save();
                        $this->view->setVar('tempImage', $image);
                    } else {
                        throw new \Exception('No image received - Please select an image for your stream');
                    }

                    $curatorsIdsAndNames = $ss->setCurators($tableId, $this->request->get('curators'));
                    $relatedListsIdsAndNames = $ss->setRelatedLists($tableId, $this->request->get('related-lists'));
                    $tagsIdsAndNames = $ss->setTags($tableId, $this->request->get('tags'));

                    $this->view->setVar('tags', empty($tagsIdsAndNames)?[]:array_column($tagsIdsAndNames, 'id'));
                    $this->view->setVar('tagsNames', empty($tagsIdsAndNames)?[]:array_column($tagsIdsAndNames, 'name'));
                    $this->view->setVar('curators', empty($curatorsIdsAndNames)?[]:array_column($curatorsIdsAndNames, 'id'));
                    $this->view->setVar('curatorsNames', empty($curatorsIdsAndNames)?[]:array_column($curatorsIdsAndNames, 'name'));
                    $this->view->setVar('relatedLists', empty($relatedListsIdsAndNames)?[]:array_column($relatedListsIdsAndNames, 'id'));
                    $this->view->setVar('relatedListsNames', empty($relatedListsIdsAndNames)?[]:array_column($relatedListsIdsAndNames, 'name'));

                    $tableContentFromCsv = $this->tableContentFromCsv($csv);
                    $this->view->setVar('tableColumns', $tableContentFromCsv[0]);
                    $this->view->setVar('tableContent', array_splice($tableContentFromCsv, 1));
                } catch (\Exception $e) {
                    $this->flash->error($e->getMessage());
                    return;
                }
            }
        }
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
            $tableContent[] = ['id' => '', 'content'=>$row];
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
}
