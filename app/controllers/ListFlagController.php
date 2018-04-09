<?php

namespace DS\Controller;

use DS\Model\Tables;
use DS\Model\TableFlags;
use DS\Interfaces\LoginAwareController;

class ListFlagController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function flagAction()
    {
        $tableId = $this->dispatcher->getParam('tableId');
        $reason = $this->dispatcher->getParam('reason');

        if ($reason != 'duplicate' && $reason != 'copyright' && $reason != 'spam' && $reason != 'inappropriate') {
            $reason = 'other';
        }

        $userId = $this->serviceManager->getAuth()->getUserId();

        $table = Tables::findFirst($tableId);

        // Check if table exists
        if ($table->count() === 0) {
            $this->flash->error('Table not found - The table you are trying to flag to does not exist');
            $this->_redirectBack();
        }

        $flags = new TableFlags();
        $flags->setUserId($userId)
                          ->setTableId($table->id)
                          ->setFlag($reason)
                          ->create();

        $this->flash->success("List flagged - Thanks for taking care, we’ll review this list");
        $this->_redirectBack();
    }
}
