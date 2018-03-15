<?php

namespace DS\Controller;

use DS\Model\Tables;
use DS\Interfaces\LoginAwareController;
use DS\Model\RequestAdd;

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

        // Mocking data from the front end  - this should come from the form submited by the user
        $content = 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eveniet inventore eaque voluptate iste provident, ipsa magni a.';
        $comment = 'Consequuntur recusandae eligendi at ut? Dolores hic sunt provident reprehenderit facere quas explicabo';
        $image = 'asasaasfsfs.jpg';

        $submission = new RequestAdd();

        $submission->table_id = $tableId;
        $submission->user_id = $user->getId();
        $submission->content = $content;
        $submission->comment = $comment;
        $submission->image = $image;

        $this->flash->success('Your submission is waiting for approval');
        $this->_redirectBack();
    }
}
