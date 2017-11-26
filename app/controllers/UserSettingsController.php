<?php

namespace DS\Controller;

use DS\Api\UserSettings;
use DS\Application;
use DS\Model\Decks;
use DS\Model\User;
use DS\Model\UserLocations;
use DS\Model\Votes;
use Phalcon\Exception;
use Phalcon\Logger;

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
class UserSettingsController
    extends BaseController
{
    /**
     * Home
     */
    public function indexAction($params = [])
    {

    }

    /**
     * @param int $id
     *
     * @return User
     */
    private function getUser($id)
    {
        $user = User::findByFieldValue('id', $id);

        /*
        if (!$user)
        {
            $this->response->redirect('/');
        }
        */

        return $user;
    }

    /**
     * Settings actions
     *
     * @param $page
     *
     * @return null|void
     */
    public function settingsAction($page)
    {
        try
        {
            $this->view->setVar('profile', $this->getUser($this->serviceManager->getAuth()->getUserId()));

            switch ($page)
            {
                case "notifications":
                    $this->notificationsAction();
                    $this->flash->success("Your account has been successfully confirmed!");
                    break;
                case "connected":
                    $this->connectedAction();
                    $this->flash->success("Your account has been successfully confirmed!");
                    break;
                case "invite":
                    $this->inviteAction();
                    $this->flash->warning("Your account will be suspended in 8 days! Update payment info now to keep your account active.");
                    break;
                case "account":
                    $this->accountAction();
                    $this->flash->warning("Your account will be suspended in 8 days! Update payment info now to keep your account active.");
                    break;
                case "wallet":
                    $this->walletAction();
                    $this->flash->notice("SpreadShare will become inactive for a brief moment due maintenance in 10 hours.");
                    break;
                case "donations":
                    $this->donationsAction();
                    $this->flash->notice("SpreadShare will become inactive for a brief moment due maintenance in 10 hours.");
                    break;
                default:
                case "personal":
                    $this->personalAction();
                    $this->flash->error("Your account has been deleted.");
                    break;
            }

        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }

        return null;
    }

    /**
     * Personal
     */
    public function personalAction()
    {
        $userId = $this->serviceManager->getAuth()->getUserId();

        if ($this->request->isPost())
        {
            if ($userId > 0)
            {
                // Prepare image
                $imagePath = '';
                if ($this->request->hasFiles() == true)
                {
                    foreach ($this->request->getUploadedFiles() as $file)
                    {
                        if ($file->getTempName() && $file->getName() && $file->getSize())
                        {
                            $imageName = md5($userId) . '.' . $file->getExtension();
                            $file->moveTo(ROOT_PATH . 'system/uploads/userimages/' . $imageName);
                            $imagePath = '/user-images/' . $imageName;
                        }
                    }
                }

                // Save user settings
                $userSettings = new UserSettings();
                $user         = $userSettings->savePersonalSettings(
                    $userId,
                    $imagePath,
                    $this->request->getPost('name'),
                    $this->request->getPost('handle'),
                    $this->request->getPost('tagline'),
                    $this->request->getPost('locations', null, []),
                    $this->request->getPost('website'),
                    true
                );

                // Send new user model to view
                $this->view->setVar('profile', $user);
            }
        }

        $locations = UserLocations::getUserLocations($userId);
        $this->view->setVar('locations', htmlentities(json_encode($locations)));

        $this->view->setMainView('user/settings/personal');
    }

    /**
     * Account
     */
    public function accountAction()
    {
        if ($this->request->isPost())
        {
            $userId = $this->serviceManager->getAuth()->getUserId();
            if ($userId > 0)
            {
                $user = (new UserSettings())->saveAccountSettings(
                    $userId,
                    $this->request->getPost('email'),
                    $this->request->getPost('password')
                );
                $this->view->setVar('profile', $user);
            }
        }

        $this->view->setMainView('user/settings/account');
    }

    /**
     * Notifications
     */
    public function notificationsAction()
    {
        $this->view->setMainView('user/settings/notifications');
    }

    /**
     * Connected Accounts
     */
    public function connectedAction()
    {
        $this->view->setMainView('user/settings/connected');
    }

    /**
     * Invite
     */
    public function inviteAction()
    {
        $this->view->setMainView('user/settings/invite');
    }

    /**
     * Wallet
     */
    public function walletAction()
    {
        $this->view->setMainView('user/settings/wallet');
    }

    /**
     * Donations
     */
    public function donationsAction()
    {
        $this->view->setMainView('user/settings/donations');
    }

}
