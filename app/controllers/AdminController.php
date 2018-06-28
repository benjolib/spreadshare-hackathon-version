<?php
namespace DS\Controller;

use DS\Application;
use DS\Interfaces\LoginAwareController;
use DS\Model\DataSource\UserRoles;
use Phalcon\Exception;
use Phalcon\Logger;

/**
 * Spreadshare
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
class AdminController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    /**
     * Admin
     */
    public function indexAction($params = [])
    {
        if (!$this->serviceManager->getAuth()->hasRole(UserRoles::Admin)) {
            $this->response->redirect("/", true);
            return;
        }

        try {
            $this->view->setMainView('admin/index');
        } catch (Exception $e) {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
}
