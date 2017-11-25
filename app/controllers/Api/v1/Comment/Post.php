<?php

namespace DS\Controller\Api\v1\Comment;

use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Record;
use DS\Controller\Api\MethodInterface;
use DS\Model\TableComments;
use DS\Model\TableStats;

/**
 *
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
class Post extends ActionHandler implements MethodInterface
{
    /**
     * @return bool
     */
    public function needsLogin()
    {
        return false;
    }
    
    /**
     * Process Post Method
     *
     * @api               {post} /api/v1/comment/:id Post and edited row
     * @apiVersion        1.0.0
     * @apiName           Table
     * @apiGroup          Public
     *
     * @apiSuccess {Object} _meta Meta object
     * @apiSuccess {int} _meta.total total number of items included in this response
     * @apiSuccess {bool} _meta.success Defines whether the request had any errors
     * @apiSuccess {bool} result
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "_meta": {
     *              "total": 1,
     *              "success": true
     *          },
     *          "data": true
     *      }
     *
     * @return mixed
     */
    public function process()
    {
        if ($this->request->isAjax())
        {
            $tableId = $this->action;
            $userId  = $this->getServiceManager()->getAuth()->getUserId();
            
            if ($userId > 0 && $this->request->getPost('comment'))
            {
                $comments = new TableComments();
                $comments->setTableId($tableId)
                         ->setUserId($userId)
                         ->setComment($this->request->getPost('comment'))
                         ->create();
                
                $tableStats = TableStats::findByFieldValue('tableId', $tableId);
                $tableStats->setCommentsCount($tableStats->getCommentsCount() + 1)->save();
                
                return new Record(['success' => 1]);
            }
        }
        
        return new Record("Nothing to do here");
    }
    
}
