<?php
namespace DS\Controller;

use DS\Model\Tables;
use DS\Model\RequestAdd;
use DS\Interfaces\LoginAwareController;
use function GuzzleHttp\json_encode;
use DS\Model\TableRows;
use DS\Api\TableContent;
use function GuzzleHttp\json_decode;

class RequestAddController extends BaseController implements LoginAwareController {
    public function needsLogin() {
        return true;
    }

    public function addAction() {
        $tableId = $this->dispatcher->getParam('id');
        $table = Tables::find($tableId);

        // Check if table exists
        if ($table->count() === 0) {
            $this->flash->error('Cannot find table - The table you are trying to add to does not exist');
            $this->_redirectBack();
        }

        $user = $this->serviceManager->getAuth()->getUser();

        // Get form data
        if ($this->request->hasFiles()) {
            $image = $this->request->getUploadedFiles();
            $image = $image[0];
            $image->moveTo('assets/images/rows/' . $image->getName());
        }

        $content = json_encode($this->request->get('cells'));

        // Clear string from quotes and brakets and commas
        $contentcleaned = str_replace(['[', ']', ',', '"'], '', $content);

        if (strlen($contentcleaned) === 0) {
            $this->flash->error('Listing empty - You can’t submit an empty listing');
            $this->_redirectBack();
            return;
        }

        $image = $image->getName();

        $submission = new RequestAdd();

        $submission->table_id = $tableId;
        $submission->user_id = $user->getId();
        $submission->content = $content;
        $submission->image = $image;

        $submission->save();

        $this->flash->success('Listing submitted - Your listing is pending review ');
        $this->_redirectBack();
    }

    public function revokeAction() {
        $submissionId = $this->dispatcher->getParam('id');

        $request = RequestAdd::find($submissionId);

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

        $request = RequestAdd::findFirst($submissionId);

        // Check if table exists
        if (!$request or $request->count() === 0) {
            $this->flash->error('Submission not found - The submission you are trying to edit does not exist');
            $this->_redirectBack();
        }
        
        $user = $this->serviceManager->getAuth()->getUser();

        if ($request->table->ownerUserId != $user->id) {
            $this->flash->error('No permission - You do not have permission to edit this submission');
            $this->_redirectBack();
        }


        // Handle approval

        $request->status = 1;
        $request->save();
        
        $content = json_decode($request->content);

        $tablecontent = new TableContent();
        $tablecontent->addRow($request->table->id, $content);

        $this->flash->success('Submission approved - You have approved this submission');
        $this->_redirectBack();
    }
}
