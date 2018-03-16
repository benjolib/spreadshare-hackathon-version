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
            $this->flash->error('The row you are trying to delete to does not exist');
            $this->_redirectBack();
        }

        $user = $this->serviceManager->getAuth()->getUser();

        $submission = new RequestDelete();
        $submission->user_id = $user->getId();
        $submission->row_id = $rowId;
        $submission->save();

        $this->flash->success('Your delete submission is waiting for approval');
        $this->_redirectBack();
    }
}
