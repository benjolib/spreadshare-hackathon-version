<?php

namespace DS\Controller;

use DS\Api\UserSettings;
use DS\Application;
use DS\Model\Locations;
use DS\Model\TableTokens;
use DS\Model\User;
use DS\Model\UserConnections;
use DS\Model\UserLocations;
use DS\Model\Wallet;
use DS\Traits\Controller\NeedsLoginTrait;
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
    use NeedsLoginTrait;
    
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
        $user = User::get($id);
        
        if (!$user->getId())
        {
            $this->response->redirect('/');
        }
        
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
            if (!$this->serviceManager->getAuth()->getUserId())
            {
                header('Location: /login');
            }
            
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
        $userId = $this->serviceManager->getAuth()->getUserId();
        
        if ($this->request->isPost())
        {
            $locations = Locations::getByIds($this->request->getPost('locations', null, []));
            try
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
                    $userSettings->savePersonalSettings(
                        $userId,
                        $imagePath,
                        $this->request->getPost('name'),
                        $this->request->getPost('handle'),
                        $this->request->getPost('tagline'),
                        $this->request->getPost('locations', null, []),
                        $this->request->getPost('website'),
                        true
                    );
                    
                    $userSettingsModel = \DS\Model\UserSettings::get($userId, 'userId');
                    $userSettingsModel->setShowTokensOnProfilePage($this->request->getPost('showTokensOnProfilePage'))->save();
                    $this->view->setVar('settings', $userSettingsModel);
                    
                    // Reload user data
                    $this->view->setVar('profile', $this->getUser($userId));
                }
            }
            catch (\Exception $e)
            {
                $this->flash->error($e->getMessage());
            }
            finally
            {
                // Send new user model to view
                $this->view->setVar('post', $this->request->getPost());
            }
        }
        else
        {
            $locations = UserLocations::getUserLocations($userId);
        }
        
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
        $userId = $this->serviceManager->getAuth()->getUserId();
        if ($userId > 0)
        {
            $userSettingsModel = \DS\Model\UserSettings::findByFieldValue('userId', $userId);
            if (!$userSettingsModel)
            {
                $userSettingsModel = new \DS\Model\UserSettings;
                $userSettingsModel->setUserId($userId);
            }
        }
        
        if ($this->request->isPost())
        {
            $userSettingsModel->setTopicDigest($this->request->getPost('topicDigest'))
                              ->setFollowDigest($this->request->getPost('followerDigest'))
                              ->setNewProductAnnouncements($this->request->getPost('newProductAnnouncements'))
                              ->save();;
        }
        
        $this->view->setVar('settings', \DS\Model\UserSettings::findByFieldValue('userId', $userId));
        $this->view->setMainView('user/settings/notifications');
    }
    
    /**
     * Connected Accounts
     */
    public function connectedAction()
    {
        $connectedAccounts = UserConnections::get($this->serviceManager->getAuth()->getUserId(), 'userId');
        if ($this->request->isPost())
        {
            if (!$connectedAccounts->getUserId())
            {
                $connectedAccounts->setUserId($this->serviceManager->getAuth()->getUserId());
            }
            
            foreach ($this->request->getPost('link', null, []) as $key => $value)
            {
                if (method_exists($connectedAccounts, 'set' . ucfirst($key)))
                {
                
                }
                call_user_func(
                    [
                        $connectedAccounts,
                        'set' . ucfirst($key),
                    ],
                    $value
                );
            }
            
            $connectedAccounts->save();
            
        }
        
        $this->view->setVar('connections', $connectedAccounts);
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
        $userId = $this->serviceManager->getAuth()->getUserId();
        
        $walletModel = Wallet::findByFieldValue('userId', $userId);
        $this->view->setVar('wallet', $walletModel);
        
        $tableTokensModel = new TableTokens();
        $this->view->setVar('tableTokens', $tableTokensModel->getTokens($userId));
        
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
