<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;

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
class ChangeRequestController extends BaseController implements LoginAwareController
{
    /**
     * @return bool
     */
    public function needsLogin()
    {
        return true;
    }

    /**
     * ChangeRequest
     */
    public function indexAction($params = [])
    {
        $user = $this->serviceManager->getAuth()->getUser();
        $changes = $user->getRequests();

        $this->view->changes = $changes;
    }
}
