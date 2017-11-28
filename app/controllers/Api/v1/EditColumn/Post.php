<?php

namespace DS\Controller\Api\v1\EditColumn;

use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Record;
use DS\Controller\Api\MethodInterface;
use DS\Model\TableColumns;
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
     * @api               {post} /api/v1/edit-column/:tableId Post an edited row (:tableId is the id of the table)
     * @apiParam {String} [title]  Title
     * @apiParam {String} [columnId]  Column Id
     * @apiVersion        1.0.0
     * @apiName           Edit Column
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
        $tableId = $this->action;
        $post    = json_decode($this->request->getRawBody(), true);
        
        if ($tableId > 0 && isset($post['columnId']) && $post['columnId'] > 0)
        {
            $columnId = $post['columnId'];
            
            $columModel = TableColumns::findFirstById($columnId);
            if (!$columModel)
            {
                throw new \InvalidArgumentException('The column that you want to edit does not exist.');
            }
            
            $tableModel = (Tables::findFirstById($columModel->getTableId()));
            
            // User is Owner and can directly edit!
            if ($tableModel->getOwnerUserId() == $this->getServiceManager()->getAuth()->getUserId())
            {
                $columModel->setTitle($post['title'] ?: '')->save();
            }
            // User contribution has to be confirmed first.
            else
            {
                
            }
            
            return new Record(true);
        }
        
        return new Record(false);
    }
    
}
