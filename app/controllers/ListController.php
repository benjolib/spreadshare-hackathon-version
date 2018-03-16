<?php

namespace DS\Controller;

use DS\Application;
use Phalcon\Exception;
use Phalcon\Logger;
use DS\Model\Tables;
use DS\Model\Helper\TableFilter;
use DS\Model\DataSource\TableFlags;
use DS\Api\TableContent;
use DS\Model\TableComments;
use DS\Model\TableStats;
use DS\Controller\Api\Meta\Records;
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;

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

class ListController extends BaseController
{
    public function indexAction($tableId = null)
    {
        try {
            // url checks

            if (!$tableId) {
                $this->response->redirect('/');
                return;
            }

            // models

            $tableModel = Tables::get($tableId);
            $tableContentModel = new TableContent();
            $tableCommentsModel = new TableComments();
            $tableStatsModel = new TableStats();

            // access checks

            if ($tableModel->getFlags() == TableFlags::Deleted) {
                throw new Exception('This list has been deleted!');
            }
            if ($tableModel->getFlags() == TableFlags::Archived) {
                throw new Exception('This list has been archived! Maybe it was flagged as inappropriate content.');
            }
            if ($tableModel->getFlags() == TableFlags::Unpublished && $tableModel->getOwnerUserId() != $this->serviceManager->getAuth()->getUserId()) {
                throw new Exception('You are not allowed to view this table.');
            }

            // actions

            if ($this->request->isPost()) {
                if ($this->request->getPost('comment')) {
                    $tableCommentsModel->setUserId($this->serviceManager->getAuth()->getUserId())
                             ->setTableId($tableId)
                             ->setParentId($this->request->getPost('parentId') ?: null)
                             ->setVotesCount(0)
                             ->setComment($this->request->getPost('comment'))
                             ->create();
                    header('Location: /list/' . $tableId);
                }
            }

            // table

            $table = $tableModel->findTablesAsArray(
                $this->serviceManager->getAuth()->getUserId(),
                (new TableFilter)->addTableId($tableId),
                TableFlags::All
            )[0];

            // table content

            $tableContent = new Records($tableContentModel->getTableData($tableId, $this->serviceManager->getAuth()->getUserId()));

            $tableContentRowsWithVotes = array_map(function ($item, $index) use ($tableContent) {
                return [
                'id' => $item['id'],
                'content' => array_map(function ($cell) {
                    $newContent = preg_replace_callback('/((http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?)/', function ($matches) {
                        return '<a class="re-table-link" target="_blank" title="' . $matches[0] . '" href="' . $matches[0] . '">' . str_ireplace('www.', '', parse_url($matches[0])['host']) . '</a>';
                    }, $cell['content']);
                    $arr = [
                    'id' => $cell['id'],
                    'content' => $newContent,
                    'link' => $cell['link'],
                    'minWidth' => strlen($cell['content'])
                  ];

                    $len = strlen($cell['content']);

                    if ($len > 160) {
                        $arr['minWidth'] = 500;
                    } elseif ($len > 80) {
                        $arr['minWidth'] = 200;
                    } elseif ($len > 40) {
                        $arr['minWidth'] = 175;
                    } elseif ($len > 20) {
                        $arr['minWidth'] = 150;
                    } else {
                        $arr['minWidth'] = 0;
                    }

                    return $arr;
                }, $item['content']),
                'votes' => $tableContent['votes'][$index]['votes'],
                'upvoted' => $tableContent['votes'][$index]['upvoted'],
                'image' => $item['image'],
              ];
            }, $tableContent['rows'], array_keys($tableContent['rows']));

            $tableContentRowsWithVotesSortedByVotes = array_orderby($tableContentRowsWithVotes, 'votes', SORT_DESC);

            // table comments

            $commentsArray = $tableCommentsModel->getComments($tableId);
            foreach ($commentsArray as $key => $comment) {
                $commentsArray[$key]['childs'] = $tableCommentsModel->getComments($tableId, $comment['id']);
            }

            // table stats

            $tableStats = $tableStatsModel->get($tableId, 'tableId');

            // set view variables

            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

            // Create a Model paginator, show 10 rows by page starting from $currentPage
            $paginator = new PaginatorArray(
                [
                    'data' => $tableContentRowsWithVotesSortedByVotes,
                    'limit' => 10,
                    'page' => $currentPage,
                ]
            );

            // Get the paginated results
            $page = $paginator->getPaginate();

            $this->view->setVar('table', $table);
            $this->view->setVar('tableContent', $tableContent);
            $this->view->setVar('tableComments', $commentsArray);
            $this->view->setVar('tableStats', $tableStats);
            $this->view->setVar('page', $page);
            $this->view->setVar('tableId', $tableId);
        } catch (Exception $e) {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
}
