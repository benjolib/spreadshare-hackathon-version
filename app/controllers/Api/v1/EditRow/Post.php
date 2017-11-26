<?php

namespace DS\Controller\Api\v1\EditRow;

use DS\Api\TableContent;
use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Record;
use DS\Controller\Api\MethodInterface;
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
     * @api               {post} /api/v1/edit-row/:tableId Post an edited row (:tableId is the id of the table)
     * @apiParam {String} [rowData]  The row as a json string
     * @apiParam {String} [lineNumber]  Row Index / Line Number
     * @apiVersion        1.0.0
     * @apiName           Edit Row
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
            $tableId    = $this->action;
            $lineNumber = $this->request->getPost('lineNumber');
            $rowData    = $this->request->getPost('rowData');
            
            if ($tableId > 0 && $lineNumber > 0 && $rowData)
            {
                $tableModel = Tables::findFirstById($tableId);
                if (!$tableModel)
                {
                    throw new \InvalidArgumentException('The table that you want to edit does not exist.');
                }
                
                // User is Owner and can directly edit!
                if ($tableModel->getOwnerUserId() == $this->getServiceManager()->getAuth()->getUserId())
                {
                    $tableContent = new TableContent();
                    $tableContent->editRow($tableId, $lineNumber, $rowData);
                }
                // User contribution has to be confirmed first.
                else
                {
                
                }
                
                return new Record(true);
            }
        }
        
        return new Record(false);
    }
    
}
