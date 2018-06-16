<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;
use DS\Model\TableSubscription;

class SubscriptionsController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function indexAction()
    {
        $userId = $this->serviceManager->getAuth()->getUserId();
        if ($this->request->isPost() && $this->request->has('table_id')&&$this->request->has('subscription_freq')){
            /** @var TableSubscription $subscription */
            $subscription=TableSubscription::findFirst([
                'tableId = ?0 AND userId = ?1',
                'bind' => [
                    0 => $this->request->get('table_id'),
                    1 => $userId
                ]
            ]);
            if (empty($subscription)) {
                $subscription = new TableSubscription();
                $subscription->setTableId($this->request->get('table_id'))
                    ->setUserId($userId);
            }
            $freq = $this->request->get('subscription_freq');
            switch ($freq) {
                case 'U':
                    $subscription->delete();
                    break;
                case 'D':
                case 'W':
                case 'M':
                    $subscription->setType($freq)->save();
                    break;
            }
        }
        $subscriptions = TableSubscription::findUserSubscriptions($userId);
        $this->view->setVar('subscriptions', $subscriptions);
        $this->view->setMainView('subscriptions/index');
    }
}
