<?php

namespace DS\Controller\Api\v1\Table;

use DS\Api\TableContent;
use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Records;
use DS\Controller\Api\MethodInterface;

/**
 *
 * Spreadshare
 *
 * @author            Dennis Stücken
 * @license           proprietary
 * @copyright         Spreadshare
 * @link              https://www.spreadshare.co
 *
 * @version           $Version$
 * @package           DS\Controller
 *
 */
class Get extends ActionHandler implements MethodInterface
{
    /**
     * @return bool
     */
    public function needsLogin()
    {
        return false;
    }
    
    /**
     * Process Get Method
     *
     * @api               {get} /api/v1/table/:id Get table data for table id
     * @apiVersion        1.0.0
     * @apiName           Table
     * @apiGroup          Public
     *
     * @apiSuccess {Object} _meta Meta object
     * @apiSuccess {int} _meta.total total number of items included in this response
     * @apiSuccess {bool} _meta.success Defines whether the request had any errors
     * @apiSuccess {Object[]} data Array of locations
     * @apiSuccess {string} data.data Meta Information for table
     * @apiSuccess {string} data.columns Array of columns
     * @apiSuccess {string} data.rows Array of rows
     * @apiSuccess {string} data.votes Array of votes
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "_meta": {
     *              "total": 4,
     *              "success": true
     *          },
     *          "data": [
     *              {
     *                  "data": {
     *                    "title": "Table Title",
     *                  },
     *                  "columns": ["Column 1","Column 2","Column 3"],
     *                  "rows": [["Cell 1", "Cell 2", "Cell 3"], ["Cell 1", "Cell 2", "Cell 3"]],
     *                  "votes": [[1, 0, 3], [0, 2, 6]],
     *              },
     *          ]
     *      }
     *
     * @return mixed
     */
    public function process()
    {
        $tableId = (int) $this->action;
        
        if (!$tableId)
        {
            throw new \InvalidArgumentException('Invalid table id');
        }
        
        $tableContent = new TableContent();
        
        return new Records($tableContent->getTableData($tableId, $this->getServiceManager()->getAuth()->getUserId()));
    }
    
}
