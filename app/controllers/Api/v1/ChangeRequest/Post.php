<?php

namespace DS\Controller\Api\v1\ChangeRequest;

use DS\Controller\Api\ActionHandler;
use DS\Controller\Api\Meta\Record;
use DS\Controller\Api\MethodInterface;
use DS\Exceptions\SecurityException;
use DS\Model\ChangeRequests;
use DS\Model\DataSource\ChangeRequestStatus;
use DS\Model\TableCells;
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
     * @api               {post} /api/v1/change-request/:changeReqId Commit or Reject a change request based on it's id
     * @apiParam {String} [comment]  User Comment
     * @apiParam {String} [type]  The change request type (can be confirm or reject)
     * @apiVersion        1.0.0
     * @apiName           Commit/Reject Change Request
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
        $changeRequestId = (int) filter_var($this->action, FILTER_SANITIZE_NUMBER_INT);
        $comment         = filter_var($this->request->getPost('comment', null, ''), FILTER_SANITIZE_STRING);
        $typeString      = filter_var($this->request->getPost('type', null, 'reject'), FILTER_SANITIZE_STRING);
        
        return new Record($this->change($typeString, $changeRequestId, $comment));
    }
    
    /**
     * @param string $typeString
     * @param int    $changeRequestId
     * @param string $comment
     *
     * @return bool
     * @throws SecurityException
     */
    public function change(string $typeString, int $changeRequestId, string $comment = ''): bool
    {
        switch ($typeString)
        {
            case 'confirm':
                $type = ChangeRequestStatus::Confirmed;
                break;
            case 'reject':
                $type = ChangeRequestStatus::Rejected;
                break;
        }
        
        if (!isset($type))
        {
            throw new \InvalidArgumentException('Action is needed for reviewing a change request.');
        }
        
        if ($changeRequestId > 0)
        {
            $changeRequest = ChangeRequests::findFirstById($changeRequestId);
            
            if (!$changeRequest)
            {
                throw new \InvalidArgumentException('This change request does not exist.');
            }
            
            $cell  = TableCells::get($changeRequest->getCellId());
            $row   = TableRows::get($cell->getRowId());
            $table = Tables::get($row->getTableId());
            
            $userId = $this->getServiceManager()->getAuth()->getUserId();
            
            if ($table->getOwnerUserId() != $userId)
            {
                throw new SecurityException('You are not allowed to review this change request.');
            }
            
            $changeRequest->setStatus($type)
                          ->setComment($comment)
                          ->setTableId($table->getId())
                          ->save();
            
            return true;
        }
        
        return false;
    }
    
}
