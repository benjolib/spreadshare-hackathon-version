<?php

namespace DS\Controller\Api\v1\Table;

use DS\Api\TableContent;
use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Record;
use DS\Controller\Api\MethodInterface;

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
     * @api               {get} /api/v1/table/:id Post and edited row
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
            $tableId    = $this->request->getPost('rowData');
            $lineNumber = $this->request->getPost('lineNumber');
            $rowData    = $this->request->getPost('rowData');
            
            if ($tableId > 0 && $lineNumber > 0 && $rowData)
            {
                $tableContent = new TableContent();
                $tableContent->editRow($tableId, $lineNumber, $rowData);
                
                return new Record(true);
            }
        }
        
        return new Record(false);
    }
    
}
