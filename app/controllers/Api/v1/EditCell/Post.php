<?php

namespace DS\Controller\Api\v1\EditCell;

use DS\Api\TableContent;
use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Record;
use DS\Controller\Api\MethodInterface;
use DS\Model\ChangeRequests;
use DS\Model\TableCells;
use DS\Model\Tables;

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
        return true;
    }
    
    /**
     * Process Post Method
     *
     * @api               {post} /api/v1/edit-cell/:cellId Post an edited cell (:cellId is the id of the cell)
     * @apiParam {String} [content]  Cell content
     * @apiParam {String} [link]  Cell link / null if there is none
     * @apiVersion        1.0.0
     * @apiName           Edit Cell
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
            $cellId  = $this->action;
            $comment = $this->request->getPost('comment');
            $content = $this->request->getPost('content');
            $link    = $this->request->getPost('link');
            
            if ($cellId > 0 && $content)
            {
                $tableCell = TableCells::findFirstById($cellId);
                
                if (!$tableCell)
                {
                    throw new \InvalidArgumentException('The cell that you want to edit does not exist.');
                }
                
                $tableId = $tableCell->getTableColumns()->getTableId();
                
                $tableModel = Tables::findFirstById($tableId);
                if (!$tableModel)
                {
                    throw new \InvalidArgumentException('The table that you want to edit does not exist.');
                }
                
                // User is Owner and can directly edit!
                if ($tableModel->getOwnerUserId() == $this->getServiceManager()->getAuth()->getUserId())
                {
                    $tableContent = new TableContent();
                    $tableContent->editCell($tableId, $content, $link ? $link : null);
                }
                // User contribution has to be confirmed first.
                else
                {
                    $changeRequest = new ChangeRequests();
                    $changeRequest->setCellId($cellId)
                                  ->setTableId($tableId)
                                  ->setFrom($tableCell->getContent())
                                  ->setTo($content)
                                  ->setComment($comment)
                                  ->create();
                }
                
                return new Record(true);
            }
        }
        
        return new Record(false);
    }
    
}
