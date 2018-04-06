<?php

namespace DS\Controller\Api\v1\TableSearch;

use DS\Api\Table;
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
     * @api               {get} /api/v1/table-search Get table data for table id
     * @apiParam          q Search term
     * @apiVersion        1.0.0
     * @apiName           TableSearch
     * @apiGroup          Public
     *
     * @apiSuccess {Object} _meta Meta object
     * @apiSuccess {int} _meta.total total number of items included in this response
     * @apiSuccess {bool} _meta.success Defines whether the request had any errors
     * @apiSuccess {Object[]} data Array of locations
     * @apiSuccess {string} data.id Table title
     * @apiSuccess {string} data.title Table title
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "_meta": {
     *              "total": 1,
     *              "success": true
     *          },
     *          "data": [
     *              {
     *                "id": "1"
     *                "title": "Table Title"
     *              }
     *          ]
     *      }
     *
     * @return mixed
     */
    public function process()
    {
        $query = filter_var($this->request->get('q'), FILTER_SANITIZE_STRING);

        if (!$query || strlen($query) < 1) {
            throw new \InvalidArgumentException('Please provide at least 3 characters for searching.');
        }

        return new Records(Table::searchTableByName($query));
    }
}
