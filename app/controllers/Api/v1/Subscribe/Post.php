<?php

namespace DS\Controller\Api\v1\Subscribe;

use DS\Api\TableSubscription;
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
     * @api               {post} /api/v1/subscribe/:tableId Subscribe to table (:tableId is the id of the table)
     * @apiVersion        1.0.0
     * @apiName           Subscribe
     * @apiGroup          Public
     *
     * @apiSuccess {Object} _meta Meta object
     * @apiSuccess {int} _meta.total total number of items included in this response
     * @apiSuccess {bool} _meta.success Defines whether the request had any errors
     * @apiSuccess {Object[]} data Array of content types
     * @apiSuccess {string} data.voted bool true if upvoted, false if downvoted
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
     *                  "subscribed": true,
     *              }
     *          ]
     *      }
     *
     * @return mixed
     */
    public function process()
    {
        if ($this->request->isAjax() && $this->action)
        {
            $userId = $this->getServiceManager()->getAuth()->getUserId();
            
            if ($userId > 0)
            {
                return new Record(['subscribed' => (new TableSubscription())->subscribeTable($userId, $this->action)]);
            }
        }
        
        return new Record("Nothing to do here");
    }
    
}
