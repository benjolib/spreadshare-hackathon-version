<?php

namespace DS\Controller;

use DS\Model\Tables;
use DS\Model\RequestAdd;
use DS\Interfaces\LoginAwareController;
use function GuzzleHttp\json_encode;

class RequestAddController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function addAction()
    {
        $tableId = $this->dispatcher->getParam('id');
        $table = Tables::find($tableId);

        // Check if table exists
        if ($table->count() === 0) {
            $this->flash->error('The table you are trying to add to does not exist');
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
        $image = $image->getName();

        $submission = new RequestAdd();

        $submission->table_id = $tableId;
        $submission->user_id = $user->getId();
        $submission->content = $content;
        $submission->image = $image;

        $submission->save();

        $this->flash->success('Your submission is waiting for approval');
        $this->_redirectBack();
    }
}
