<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;
use DS\Model\Wallet;
use DS\Model\Tables;
use DS\Model\TableRows;
use DS\Model\TableTokens;
use Phalcon\Logger;

class KarmaController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function indexAction()
    {
        $userId = $this->serviceManager->getAuth()->getUserId();

        $walletModel = Wallet::findByFieldValue('userId', $userId);
        $this->view->setVar('wallet', $walletModel);

        $tablesModel = Tables::findByOwnerUserId($userId);
        $this->view->setVar('tableCount', count($tablesModel));

        $tableRowsModel = TableRows::findByUserId($userId);
        $this->view->setVar('submissionsCount', count($tableRowsModel));

        $page = (int) $this->request->get('page', null, 0);
        $limit = 6;

        $tableTokensModel = new TableTokens();
        $tableTokens = $tableTokensModel->getTokens($userId, 'tokensEarned', $page, $limit);

        // we fetch 1 more than limit so we can check this
        if (count($tableTokens) > $limit) {
          $tableTokens = array_slice($tableTokens, 0, $limit);
          $this->view->setVar('moreToLoad', true);
        } else {
          $this->view->setVar('moreToLoad', false);
        }

        $this->view->setVar('tableTokens', $tableTokens);

        // Inform view that this is an ajax request
        $this->view->setVar('isAjax', $this->request->isAjax());

        // Paging instead of returning the whole page
        if ($this->request->isAjax() && $this->request->has('page'))
        {
            if (count($tableTokens) === 0)
            {
              // Return nothing if tableTokens are empty for today.
              $this->view->disable();
              header('Content-Type: application/json');
              die(json_encode([
                  'code' => 'no-results'
              ]));
            }
            $this->view->setMainView('karma/content');
        }
        else
        {
            $this->view->setMainView('karma/index');
        }
    }
}
