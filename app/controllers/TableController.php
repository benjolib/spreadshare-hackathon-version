<?php

namespace DS\Controller;

use DS\Model\Tables;
use DS\Exceptions\SecurityException;
use DS\Interfaces\LoginAwareController;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
class TableController extends BaseController implements LoginAwareController
{
    /**
     * @return bool
     */
    public function needsLogin()
    {
        return true;
    }

    /**
     * Table
     */
    public function indexAction($params = [])
    {
        $this->view->setMainView('table/table');
    }

    /**
     * Table delete
     */
    public function deleteAction($tableId = null)
    {
        if (!$tableId) {
            $this->response->redirect('/');
            return;
        }

        try {
            // Assign table data to UI
            $tableModel = Tables::get($tableId);
            $userId = $this->serviceManager->getAuth()->getUserId();

            if ($tableModel->getOwnerUserId() == $userId) {
                $tableModel->delete();
                $this->flash->success('Your table has been successfully deleted.');

                header('Location:/user/' . $this->serviceManager->getAuth()->getUser()->getHandle() . '/tables');
            } else {
                throw new SecurityException('You are not allowed to delete this table.');
            }
        } catch (SecurityException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->flash->error($e->getMessage());
        }
    }
}
