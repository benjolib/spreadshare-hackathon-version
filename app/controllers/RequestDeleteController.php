<?php
namespace DS\Controller;

use DS\Model\TableRows;
use Phalcon\Http\Request;
use Phalcon\Mvc\Model\Row;
use DS\Model\RequestDelete;
use DS\Interfaces\LoginAwareController;
use spec\Http\Message\Decorator\RequestDecoratorStub;

class RequestDeleteController extends BaseController implements LoginAwareController {
    public function needsLogin() {
        return true;
    }

    public function deleteAction() {
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

    public function revokeAction() {
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

    public function approveAction() {
        $submissionId = $this->dispatcher->getParam('id');
        
        $request = RequestDelete::findFirst($submissionId);

        // Check if table exists
        if (!$request or $request->count() === 0) {
            $this->flash->error('Submission not found - The submission you are trying to edit does not exist');
            $this->_redirectBack();
        }
        
        $user = $this->serviceManager->getAuth()->getUser();

        if ($request->row->tables->ownerUserId != $user->id) {
            $this->flash->error('No permission - You do not have permission to edit this submission');
            $this->_redirectBack();
        }


        // Handle deletion
        $request->status = 1;
        $request->save();

        $row = TableRows::findFirst($request->row_id);
        $row->delete();

        $this->flash->success('Submission deleted - You have deleted this submission');
        $this->_redirectBack();
    }

    public function denyAction() {
        $submissionId = $this->dispatcher->getParam('id');
        
        $requestpost = new Request();
        $reason = $requestpost->getPost('reason');

        $request = RequestDelete::findFirst($submissionId);

        // Check if table exists
        if (!$request or $request->count() === 0) {
            $this->flash->error('Submission not found - The submission you are trying to edit does not exist');
            $this->_redirectBack();
        }
        
        $user = $this->serviceManager->getAuth()->getUser();

        if ($request->row->tables->ownerUserId != $user->id) {
            $this->flash->error('No permission - You do not have permission to edit this submission');
            $this->_redirectBack();
        }


        // Handle approval

        $request->status = 2;
        $request->comment = $reason;
        $request->save();
        

        $this->flash->success('Request to delete declined - You have declined this request to delete');
        $this->_redirectBack();
    }
}
