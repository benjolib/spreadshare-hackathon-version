<?php

namespace DS\Controller;

use DS\Application;
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

// TODO: probably move this elseware
function array_orderby()
{
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = [];
            foreach ($data as $key => $row) {
                $tmp[$key] = $row[$field];
            }
            $args[$n] = $tmp;
        }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}
function humanTiming($time)
{
    return time();
    $time = time() - $time; // to get the time since that moment

    if ($time < 60) {
        return 'Just now';
    }

    $tokens = [
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second',
    ];

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) {
            continue;
        }
        $numberOfUnits = floor($time / $unit);

        return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's ago' : ' ago');
    }

    return '';
}
class ListController extends BaseController
{
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
                    header('Location: /list/' . $tableId);
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
            }

            // table stats
            $tableStats = $tableStatsModel->get($tableId, 'tableId');
            $related = TableRelations::findRelatedTables($tableId);
            $tableColumns = TableColumns::findAllByFieldValue('tableId', $tableId);

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
}
