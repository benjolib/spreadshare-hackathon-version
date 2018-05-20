<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;
use DS\Api\UserSettings;
use DS\Application;
use DS\Model\Locations;
use DS\Model\Tables;
use DS\Model\TableRows;
use DS\Model\TableTokens;
use DS\Model\User;
use DS\Model\UserConnections;
use DS\Model\UserLocations;
use DS\Model\Wallet;
use DS\Traits\Controller\NeedsLoginTrait;
use Phalcon\Exception;
use Phalcon\Logger;

class SettingsController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function indexAction()
    {
        try {
            $userId = $this->serviceManager->getAuth()->getUserId();
            $userSettingsModel = \DS\Model\UserSettings::get($userId, 'userId');
            $connectedAccounts = UserConnections::get($this->serviceManager->getAuth()->getUserId(), 'userId');

            $this->view->setVar('settings', $userSettingsModel);

            if ($this->request->isPost()) {
                try {
                    if ($userId > 0) {
                        // Prepare image
                        $imagePath = '';
                        if ($this->request->hasFiles() == true) {
                            foreach ($this->request->getUploadedFiles() as $file) {
                                if ($file->getTempName() && $file->getName() && $file->getSize()) {
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

                        $userSettings->saveAccountSettings(
                          $userId,
                          $this->request->getPost('email'),
                          $this->request->getPost('password')
                        );

                        $userSettingsModel->setTopicDigest($this->request->getPost('topicDigest'))
                                      ->setFollowDigest($this->request->getPost('followerDigest'))
                                      ->setNewProductAnnouncements($this->request->getPost('newProductAnnouncements'))
                                      ->save();

                        $userSettingsModel->setUserId($userId)
                                      ->setShowTokensOnProfilePage($this->request->getPost('showTokensOnProfilePage'))
                                      ->save();

                        if (!$connectedAccounts->getUserId()) {
                            $connectedAccounts->setUserId($this->serviceManager->getAuth()->getUserId());
                        }

                        foreach ($this->request->getPost('link', null, []) as $key => $value) {
                            if (method_exists($connectedAccounts, 'set' . ucfirst($key))) {
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
                } catch (\Exception $e) {
                    $this->flash->success('Error - Something has gone wrong');
                    // $this->flash->error($e->getMessage());
                } finally {
                    // Send new user model to view
                    $this->view->setVar('post', $this->request->getPost());
                    $this->flash->success('Saved - Your changes have been saved');
                }
            }
        } catch (Exception $e) {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }

        $this->view->setVar('connections', $connectedAccounts);
        $this->view->setVar('settings', $userSettingsModel);
        $this->view->setVar('profile', $this->getUser($userId));
        $this->view->setMainView('settings/index');
    }

    /**
     * @param int $id
     *
     * @return User
     */
    private function getUser($id)
    {
        $user = User::get($id);

        if (!$user->getId()) {
            $this->response->redirect('/');
        }

        return $user;
    }
}
