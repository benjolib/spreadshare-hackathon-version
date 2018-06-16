<?php

namespace DS\Controller;

use DS\Application;
use DS\Model\TableCommentVotes;
use DS\Model\TableContributions;
use DS\Model\TableRows;
use DS\Services\Stream as StreamService;
use Phalcon\Logger;
use DS\Model\Tables;
use Phalcon\Exception;
use DS\Model\TableStats;
use DS\Api\TableContent;
use DS\Model\TableColumns;
use DS\Model\TableComments;
use DS\Model\Helper\TableFilter;
use DS\Model\DataSource\TableFlags;
use DS\Model\TableRelations;
use DS\Events\Table\TableViewed;

class ListController extends BaseController
{
    public function editAction($tableIdOrSlug)
    {
        $ss = new StreamService();
        $this->view->setMainView('create-list/index');
        $table = Tables::findFirstById($tableIdOrSlug);
        if (empty($table)) {
            $table = Tables::findByFieldValue('slug', $tableIdOrSlug);
            if (empty($table)) {
                throw new \Exception("Table $tableIdOrSlug doesn't exist.");
            }
        }
        $tableId = $table->getId();
        $tableColumns = array_column(TableColumns::findAllByFieldValue('tableId', $tableId)->toArray(), 'title');
        if (empty($tableColumns)) {
            throw new \Exception("Unexpected error - table $tableId without columns");
        }
        $tableContent = $this->getContentArray($tableId);
        if ($this->request->isPost()) {
            try{
                // convert strings to arrays from post
                $post = $this->request->getPost();
                $post['related-lists'] = explode(",",$this->request->getPost()['related-lists']);
                $post['curators'] = explode(",", $this->request->getPost()['curators']);
                $post['tags'] = explode(",",$this->request->getPost()['tags']);
                $this->view->setVar('post', $post);

                $table->setTitle($this->request->getPost('name'))
                    ->setTagLIne($this->request->getPost('tagline'))
                    ->setDescription($this->request->getPost('description'));
                $table->save();
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
                $this->flash->error("Unexpected error -".$e->getMessage());
                return;
            }
            $this->response->redirect("/list/" . $tableId, true);
        } else {
            $post['name'] = $table->getTitle();
            $post['tagline'] = $table->getTagline();
            $post['description'] = $table->getDescription();

           
        }
         try {
                $curatorsIds = $ss->getCuratorIdsFromTable($tableId);
                $relatedListsIds = $ss->getRelatedListsIdsFromTable($tableId);
                $tagsIds = $ss->getTagsIdsFromTable($tableId);


                $curatorsIdsAndNames = $ss->getCuratorsIdsAndNames(implode(',',$curatorsIds));
                $relatedListsIdsAndNames = $ss->getRelatedListsIdsAndTitles(implode(',',$relatedListsIds));
                $tagsIdsAndNames = $ss->getTagsIdsAndNames(implode(',',$tagsIds));
            } catch (\Exception $e) {
                $this->flash->error("Unexpected error -".$e->getMessage());
                return;
            }
        if (isset($post)) {

            $post['related-lists'] = empty($relatedListsIdsAndNames)?[]:array_column($relatedListsIdsAndNames, 'id');
            $post['curators'] = empty($curatorsIdsAndNames)?[]:array_column($curatorsIdsAndNames, 'id');
            $post['tags'] = empty($tagsIdsAndNames)?[]:array_column($tagsIdsAndNames, 'id');
            $this->view->setVar('post', $post);
        }
    
        $this->view->setVar('tempImage', $table->getImage());
        $this->view->setVar('tagsNames', empty($tagsIdsAndNames)?[]:array_column($tagsIdsAndNames, 'name'));
        $this->view->setVar('curatorsNames', empty($curatorsIdsAndNames)?[]:array_column($curatorsIdsAndNames, 'name'));
        $this->view->setVar('relatedListsNames', empty($relatedListsIdsAndNames)?[]:array_column($relatedListsIdsAndNames, 'name'));

        $this->view->setVar('tableColumns', $tableColumns);
        $this->view->setVar('tableContent', $tableContent);
        $this->view->setVar('editing', true);

    }

    public function indexAction()
    {
        try {
            $page = $this->request->getQuery('page', 'int', 1);
            $orderby = $this->request->getQuery('orderby', null, 'popularity');

            if ($orderby == 'date') {
                $orderbyquery = 'createdAt DESC';
            } else {
                $orderbyquery = 'votesCount DESC';
            }

            $authId = $this->serviceManager->getAuth()->getUserId();

            // models

            $slug = $this->dispatcher->getParam('slug');

            // Try to get table by slug
            $tableModel = Tables::findFirst([
                'conditions' => 'slug = :slug:',
                'bind' => [
                    'slug' => $slug
                ]
            ]);

            //Check if slug or id is being passed to url
            // If not, get by id
            if (!$tableModel) {
                $tableModel = Tables::findFirstById($slug);
            }

            $tableContentModel = new TableContent();
            $tableCommentsModel = new TableComments();
            $tableStatsModel = new TableStats();

            $tableId = $tableModel->id;

            TableViewed::after($authId, (int) $tableId);

            // Get Contributors
            $contributors = $tableModel->contributors->toArray();

            // Subscribers
            $subscribers = $tableModel->getSubscribers();

            // Tags

            $tags = $tableModel->getTags();

            // access checks

            if ($tableModel->getFlags() == TableFlags::Deleted) {
                throw new Exception('This list has been deleted!');
            }
            if ($tableModel->getFlags() == TableFlags::Archived) {
                throw new Exception('This list has been archived! Maybe it was flagged as inappropriate content.');
            }
            if ($tableModel->getFlags() == TableFlags::Unpublished && $tableModel->getOwnerUserId() != $authId) {
                throw new Exception('You are not allowed to view this table.');
            }

            // actions

            if ($this->request->isPost()) {
                if ($this->request->getPost('comment')) {
                    $tableCommentsModel->setUserId($authId)
                             ->setTableId($tableId)
                             ->setParentId($this->request->getPost('parentId') ?: null)
                             ->setVotesCount(0)
                             ->setComment($this->request->getPost('comment'))
                             ->create();
                    $this->flash->success('Comment added - Your comment was added');
                    $this->_redirectBack();
                }
            }

            $table = $tableModel->findTablesAsArray(
                $authId,
                (new TableFilter)->addTableId($tableId),
                TableFlags::All
            )[0];

            $tableContent = $tableContentModel->paginatedDatas($tableId, $authId, $orderbyquery, $page);

            // table comments

            $commentsArray = $tableCommentsModel->getComments($tableId);
            foreach ($commentsArray as $key => $comment) {
                $commentsArray[$key]['childs'] = $tableCommentsModel->getChildComments($tableId, $comment['id']);
                // TODO this should be optimized, we are doing an extra query for each comment. I'm sorry to have done
                // it this way, but the time constraints were imposing releasing the project over quality of the code.
                $commentsArray[$key]['voted'] = !empty(TableCommentVotes::findByUserIdAndComment($authId, $comment['id']));
            }

            // table stats
            $tableStats = $tableStatsModel->get($tableId, 'tableId');
            $related = TableRelations::findRelatedTables($tableId);
            foreach ($related as $key => $value) {
                $related[$key]['subscriberCount'] = TableStats::get($value['id'])->getSubscriberCount();
            }
            $tableColumns = TableColumns::findAllByFieldValue('tableId', $tableId);

            $this->view->setMainView('list/index');
            $this->view->setVar('table', $table);
            $this->view->setVar('tableContent', $tableContent);
            $this->view->setVar('tableComments', $commentsArray);
            $this->view->setVar('tableStats', $tableStats);
            $this->view->setVar('tableColumns', $tableColumns);
            $this->view->setVar('related', $related);
            $this->view->setVar('contributors', $contributors);
            $this->view->setVar('subscribers', $subscribers);
            $this->view->setVar('orderby', $orderby);
            $this->view->setVar('userId', $authId);
            $this->view->setVar('tags', $tags);
            $this->view->setVar('tablemodel', $tableModel);

            /* foreach ($tableModel->contributors as $c) {
                var_dump($c->users);
            }

            exit; */
        } catch (Exception $e) {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }

    private function getContentArray(int $tableId) :array
    {
        $tableContent = TableRows::findRowsFrom($tableId);
        $result = [];
        foreach ($tableContent as $row) {
            $result[] = [
                'id' => $row->getId(),
                'content' => array_column(json_decode($row->getContent(), true), 'content')
            ];
        }
        return $result;
    }
}
