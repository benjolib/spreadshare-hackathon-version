<?php

namespace DS\Controller;

use DS\Api\UserSettings;
use DS\Application;
use DS\Model\Decks;
use DS\Model\User;
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
                    break;
                case "connected":
                    $this->connectedAction();
                    break;
                case "invite":
                    $this->inviteAction();
                    break;
                case "account":
                    $this->accountAction();
                    break;
                case "wallet":
                    $this->walletAction();
                    break;
                case "donations":
                    $this->donationsAction();
                    break;
                default:
                case "personal":
                    $this->personalAction();
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
        if ($this->request->isPost())
        {
            $userId = $this->serviceManager->getAuth()->getUserId();
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
                    [],
                    $this->request->getPost('website'),
                    true
                );
                
                // Send new user model to view
                $this->view->setVar('profile', $user);
            }
        }
        
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
