<?php

namespace DS\Controller;

use DS\Model\Tables;
use DS\Model\TableSubscription;
use DS\Interfaces\LoginAwareController;

class ListSubscriptionController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function subscribeAction()
    {
        $tableId = $this->dispatcher->getParam('tableId');
        $userId = $this->serviceManager->getAuth()->getUserId();

        $table = Tables::find($tableId);

        // Check if table exists
        if ($table->count() === 0) {
            $this->flash->error('Table not found - The table you are trying to add to does not exist');
            $this->_redirectBack();
        }

        $subscription = new TableSubscription();
        $subscription->subscribe($userId, $tableId);

        $this->flash->success('Subscribed - You have been subscribed to this list');
        $this->_redirectBack();
    }
}
