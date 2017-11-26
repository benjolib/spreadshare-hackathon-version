<?php

namespace DS\Controller\Api\v1\FollowUser;

use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Record;
use DS\Controller\Api\MethodInterface;
use DS\Model\UserFollower;

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
     * @api               {post} /api/v1/follow-user/:userId Follow a user
     * @apiVersion        1.0.0
     * @apiName           Topics
     * @apiGroup          Public
     *
     * @apiSuccess {Object} _meta Meta object
     * @apiSuccess {int} _meta.total total number of items included in this response
     * @apiSuccess {bool} _meta.success Defines whether the request had any errors
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "_meta": {
     *              "total": 1,
     *              "success": true
     *          },
     *          "data": {"id":"1","userId":1,"followedByUserId":1,"createdAt":1511663305}
     *      }
     *
     * @return mixed
     */
    public function process()
    {
        if ($this->request->isAjax() && $this->action)
        {
            $userId = $this->getServiceManager()->getAuth()->getUserId();
            
            $followUser = new UserFollower();
            $followUser->toggleFollow($userId, $this->action);
            
            return new Record($followUser->toArray());
        }
        
        return new Record("Nothing to do here");
    }
    
}
