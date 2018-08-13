<?php

namespace DS\Controller;

use DS\Component\Text\Csv;
use DS\Exceptions\InvalidStreamDescriptionException;
use DS\Exceptions\InvalidStreamTaglineException;
use DS\Exceptions\InvalidStreamTitleException;
use DS\Interfaces\LoginAwareController;
use DS\Model\DataSource\TableFlags;
use DS\Model\DataSource\UserRoles;
use DS\Model\Tables;
use DS\Services\Stream as StreamService;
use Phalcon\Filter;

class CreateListController extends BaseController implements LoginAwareController
{
    /**
     * @return bool
     */
    public function needsLogin()
    {
        return true;
    }

    /**
     *
     */
    public function indexAction()
    {
        $user = $this->serviceManager->getAuth()->getUser();

        // user has to be a Curator in order to create a stream
        if (!$user->hasRole(UserRoles::Curator)) {
            $this->response->redirect("/stream/become-a-curator", true);
            return;
        }

        // setup view - it is required fir Stream creation screen
        $this->view->setMainView('create-list/index');
        $this->view->setVar('editing', false);

        if (!$this->request->isPost()) {
            // in case we are just entring the page - display the view and that's all for now
            return;
        }

        $streamService = new StreamService();
        // convert strings to arrays from post
        $post = $this->request->getPost();

        $post['related-lists'] = explode(",",$this->request->getPost('related-lists','string'));
        $post['curators'] = explode(",", $this->request->getPost('curators', 'string'));
        $post['tags'] = explode(",",$this->request->getPost('tags', 'string'));

        $this->view->setVar('post', $post);

        if ($this->request->get('step') == '2') {
            // publish Stream

            $tableId = $this->request->get('tableId');
            $table = Tables::findFirstById($tableId);
            try {
                $streamService->setCurators($tableId, $this->request->get('curators','string'));
                $streamService->setRelatedLists($tableId, $this->request->get('related-lists','string'));
                $streamService->setTags($tableId, $this->request->get('tags','string'));
                $streamService->setColumns($tableId, $this->request->get('list-columns','striptags'));
                $streamService->setRows($tableId, $this->request->get('list-rows','striptags'), $this->request->getUploadedFiles(true));
                    $imagePath = $streamService->getImagePath(
                        $tableId,
                        $this->request->getUploadedFiles(true)
                    );
                    if (!empty($imagePath)) {
                        $table->setImage($imagePath)->save();
                    }
                    $table->setFlags(TableFlags::Published);
                    try {
                        $table
                            ->setTitle($this->request->get('name', 'string'))
                            ->setTagline($this->request->get('tagline', 'string'))
                            ->setDescription($this->request->get('description', 'string'))
                            ->save();

                    } catch (InvalidStreamTitleException $e) {
                        throw new \Exception('Title missing - ' . $e->getMessage());
                    } catch (InvalidStreamTaglineException $e) {
                        throw new \Exception('Tagline missing - ' . $e->getMessage());
                    } catch (InvalidStreamDescriptionException $e) {
                        throw new \Exception('Description missing - ' . $e->getMessage());
                    } catch (\Exception $e) {
                        throw new \Exception('Undetermined error on stream - '. $e->getMessage());
                    }
                } catch (\Exception $e) {
                    $this->flash->error($e->getMessage());
                    return;
                }

            // looks like Stream created successfully
            $streamService->sendSlackNotification($table);
            $this->response->redirect("/stream/" . $table->getSlug(), true);

        } else {
            // prepare Stream for publications
            try {
                if (empty($this->request->getPost('tableId','int'))) {
                    // new Table has to be created
                    $table = new Tables();
                    $table
                        ->setOwnerUserId($user->getId())
                        ->setFeatured(0)
                        ->save();
                } else {
                    // table specified - find it in the DB
                    $table = Tables::findFirstById($this->request->getPost('tableId','int'));
                }
                $tableId = $table->getId();
                $this->view->setVar('tableId', $tableId);

                $imagePath = $streamService->getImagePath(
                    $tableId,
                    $this->request->getUploadedFiles(true)
                );
                if (!empty($imagePath)) {
                    $table
                        ->setTitle('temptitle'.rand(0,5000))
                        ->setImage($imagePath)
                        ->save();
                    $this->view->setVar('tempImage', $imagePath);
                } else if (empty($table->getImage())) {
                    throw new \Exception('Image missing - Please select an image for your Stream');
                }

                // assume CSV file from 'copy+paste' field
                $csv = $this->request->get('copy','string');

                // in case CSV file attached - it has a priority
                if ($this->request->hasFiles(true)) {
                    foreach ($this->request->getUploadedFiles(true) as $key => $uploadedFile) {
                        switch ($uploadedFile->getKey()) {
                            case 'file':
                                $csv = file_get_contents($uploadedFile->getTempName());
                                break;
                        }
                    }
                }

                // process CSV data
                $csv = (new Filter())->sanitize($csv, 'string');

                $curatorsIdsAndNames = $streamService->setCurators($tableId, $this->request->get('curators','string'));
                $relatedListsIdsAndNames = $streamService->setRelatedLists($tableId, $this->request->get('related-lists','string'));
                $tagsIdsAndNames = $streamService->setTags($tableId, $this->request->get('tags','string'));

                $this->view->setVar('tags', empty($tagsIdsAndNames)?[]:array_column($tagsIdsAndNames, 'id'));
                $this->view->setVar('tagsNames', empty($tagsIdsAndNames)?[]:array_column($tagsIdsAndNames, 'name'));
                $this->view->setVar('curators', empty($curatorsIdsAndNames)?[]:array_column($curatorsIdsAndNames, 'id'));
                $this->view->setVar('curatorsNames', empty($curatorsIdsAndNames)?[]:array_column($curatorsIdsAndNames, 'name'));
                $this->view->setVar('relatedLists', empty($relatedListsIdsAndNames)?[]:array_column($relatedListsIdsAndNames, 'id'));
                $this->view->setVar('relatedListsNames', empty($relatedListsIdsAndNames)?[]:array_column($relatedListsIdsAndNames, 'name'));

                $tableContentFromCsv = $this->tableContentFromCsv($csv);
                $this->view->setVar('tableColumns', $tableContentFromCsv[0]);
                $this->view->setVar('tableContent', array_splice($tableContentFromCsv, 1));
                $this->view->setVar('editing', true);
                try {
                    $table
                        ->setTitle($this->request->get('name','string'))
                        ->setTagline($this->request->get('tagline','string'))
                        ->setDescription($this->request->get('description','string'))
                        ->save();
                } catch (InvalidStreamTitleException $e) {
                    throw new \Exception('Title missing - ' . $e->getMessage());
                } catch (InvalidStreamTaglineException $e) {
                    throw new \Exception('Tagline missing - ' . $e->getMessage());
                } catch (InvalidStreamDescriptionException $e) {
                    throw new \Exception('Description missing - ' . $e->getMessage());
                } catch (\Exception $e) {
                    throw new \Exception('Undetermined error on stream - '. $e->getMessage());
                }
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
                return;
            }
        }
    }

    /**
     * @param $csvString
     * @return array
     */
    protected function tableContentFromCsv($csvString): array
    {
        if (strpos($csvString, "\t") !== false) {
            $separator = "\t";
        } else {
            $separator = ",";
        }

        $csv = new Csv();
        $rows = $csv->parseFromText($csvString, $separator, true, true);
        $result = [];
        foreach ($rows as $row) {
            $result[] = ['id' => '', 'content'=>$row];
        }
        $result[0] = $rows[0];
        return $result;
    }

}
