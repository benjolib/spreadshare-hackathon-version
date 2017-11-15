<?php

namespace DS\Controller\Api\v1\Topics;

use DS\Api\Topics;
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
     * @api               {get} /api/v1/topics Request all topics
     * @apiVersion        1.0.0
     * @apiName           Topics
     * @apiGroup          Public
     *
     * @apiSuccess {Object} _meta Meta object
     * @apiSuccess {int} _meta.total total number of items included in this response
     * @apiSuccess {bool} _meta.success Defines whether the request had any errors
     * @apiSuccess {Object[]} data Array of topics
     * @apiSuccess {string} data.id Id of topic
     * @apiSuccess {string} data.title Title of topic
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "_meta": {
     *              "total": 3,
     *              "success": true
     *          },
     *          "data": [
     *              {
     *                  "id": "1",
     *                  "title": "Engineering & Tech",
     *              },
     *              {
     *                  "id": "2",
     *                  "title": "Design & Product",
     *              },
     *              {
     *                  "id": "3",
     *                  "title": "Growth & Marketing",
     *              }
     *          ]
     *      }
     *
     * @return mixed
     */
    public function process()
    {
        return new Records(Topics::getAll());
    }
    
}
