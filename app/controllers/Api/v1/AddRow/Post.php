<?php

namespace DS\Controller\Api\v1\AddRow;

use DS\Api\TableContent;
use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Record;
use DS\Controller\Api\MethodInterface;
use DS\Model\TableRows;
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
     * @api               {post} /api/v1/add-row/:tableId Post a new row (:tableId is the id of the table)
     * @apiParam {String} [rowData]  The row as a json string
     * @apiParam {String} [insertAfterId]  Inserts the row after given id - This has to be a rowId!
     * @apiVersion        1.0.0
     * @apiName           Add Row
     * @apiGroup          Public
     *
     * @apiSuccess {Object} _meta Meta object
     * @apiSuccess {int} _meta.total total number of items included in this response
     * @apiSuccess {bool} _meta.success Defines whether the request had any errors
     * @apiSuccess {Object} result
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "_meta": {
     *            "total": 1,
     *            "success": true
     *          },
     *          "data": {
     *             "id": null
     *             "cells": null,
     *             "action" => "changeRequested"
     *          }
     *      }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "_meta": {
     *            "total": 1,
     *            "success": true
     *          },
     *          "data": {
     *             "id": 312312
     *             "cells": {
     *                "32": {
     *                  "id": "32",
     *                  "content" "cell-content"
     *                }
     *             },
     *             "action" => "updated"
     *          }
     *      }
     *
     * @return mixed
     */
    public function process()
    {
        $tableId       = $this->action;
        $insertAfterId = $this->request->getPost('insertAfterId');
        $rowData       = json_decode($this->request->getPost('rowData'), true);
        $userId        = $this->getServiceManager()->getAuth()->getUserId();
        
        if ($userId > 0 && $tableId > 0 && is_array($rowData))
        {
            $tableModel = Tables::findFirstById($tableId);
            if (!$tableModel)
            {
                throw new \InvalidArgumentException('The table that you want to edit does not exist.');
            }
            
            // User is Owner and can directly edit!
            if ($tableModel->getOwnerUserId() == $userId)
            {
                $tableContent = new TableContent();
                $newRow       = $tableContent->addRow($tableId, $rowData, $insertAfterId);
                
                $action = 'updated';
            }
            // User contribution has to be confirmed first.
            else
            {
                /**
                 * @todo not implemented yet!
                 */
                $newRow = new TableRows();
                /*
                $cellId = null;
                $changeRequest = new ChangeRequests();
                $changeRequest->setTableId($tableId)
                              ->setUserId($userId)
                              ->setFrom('')
                              ->setTo('')
                              ->setStatus(ChangeRequestStatus::Unconfirmed)
                              ->setComment('')
                              ->setCellId($cellId);
                */
                
                $action = 'changeRequested';
            }
            
            return new Record(
                [
                    'id' => $newRow->getId(),
                    'cells' => $newRow->getContent(),
                    'action' => $action,
                ]
            );
        }
        
        throw new Exception('Error adding the row. Either you are not loggedin, or the table-id or submitted row is incorrect.');
    }
    
}
