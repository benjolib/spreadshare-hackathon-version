<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;
use DS\Model\TableRows;
use DS\Model\RequestDelete;

class RequestDeleteController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function deleteAction()
    {
        $rowId = $this->dispatcher->getParam('id');
        $row = TableRows::find($rowId);

        // Check if row exists
        if ($row->count() === 0) {
            $this->flash->error('Row not found - The row you are trying to delete to does not exist');
            $this->_redirectBack();
        }

        $user = $this->serviceManager->getAuth()->getUser();

        $submission = new RequestDelete();
        $submission->user_id = $user->getId();
        $submission->row_id = $rowId;
        $submission->save();

        $this->flash->success('Submission deletion requested - Your delete submission request is waiting for approval');
        $this->_redirectBack();
    }

    public function revokeAction()
    {
        $submissionId = $this->dispatcher->getParam('id');

        $request = RequestDelete::find($submissionId);

        // Check if table exists
        if ($request->count() === 0) {
            $this->flash->error('Submission not found - The submission you are trying to edit does not exist');
            $this->_redirectBack();
        }

        $user = $this->serviceManager->getAuth()->getUser();

        if ($request->getFirst()->user_id != $user->id) {
            $this->flash->error('No permission - You do not have permission to edit this submission');
            $this->_redirectBack();
        }

        $request->delete();
        $this->flash->success('Submission revoked - You have revoked this submission');
        $this->_redirectBack();
    }
}
