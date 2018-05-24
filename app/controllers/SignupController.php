<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;
use DS\Application;
use DS\Model\DataSource\TableFlags;
use DS\Model\DataSource\UserStatus;
use DS\Model\Helper\TableFilter;
use DS\Model\Tables;
use DS\Model\Topics;
use DS\Model\User;
use DS\Model\UserFollower;
use DS\Model\UserLocations;
use DS\Model\UserTopics;
use Phalcon\Exception;
use Phalcon\Logger;


class SignupController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function indexAction()
    {
        $user = $this->serviceManager->getAuth()->getUser();
        if ($user->getStatus() == UserStatus::OnboardingIncomplete) {
            // Login request with username and password
            if ($this->request->isPost() && $this->request->getPost('username') && $this->request->getPost('email')) {

                $user
                    ->setHandle($this->request->getPost('username'))
                    ->setEmail($this->request->getPost('email'))
                    ->save();
                header('Location: /signup/topics');
            }

        }
        $this->view->setVar('hideHeader', true);
        $this->view->setMainView('sign-up/index');
    }

    public function topicsAction($params = [])
    {
        try {
//            $this->redirectIfNotLoggedIn();

            $user = $this->serviceManager->getAuth()->getUser();

            if (!$user ||
                ($user->getStatus() != UserStatus::OnboardingIncomplete && $user->getStatus() != UserStatus::Unconfirmed)) {
                // Onboarding already done
                header('Location: /');
            }

            $topics = (new Topics())->find();

            $this->view->setVar('searchDisabled', true);
            $this->view->setVar('topics', $topics);
            $this->view->setMainView('auth/onboarding/topics');
        } catch (\Exception $e) {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }

    /**
     * Follow
     */
    public function followAction($params = [])
    {
        try {
//            $this->redirectIfNotLoggedIn();

            if ($this->request->isPost()) {
                $topics = $this->request->getPost('topic');
                if (is_array($topics) && count($topics)) {
                    // Handle Topics
                    (new UserTopics())->setTopicsByUserId(
                        $this->serviceManager->getAuth()->getUserId(),
                        $topics
                    );
                }
            }

            $users = (new User())->find(
                [
                    'conditions' => 'id != ?0',
                    'bind' => [$this->serviceManager->getAuth()->getUserId()],
                    'order' => 'RAND()',
                    'limit' => 20,
                ]
            );

            $this->view->setVar('searchDisabled', true);
            $this->view->setVar('users', $users);

            $this->view->setMainView('auth/onboarding/follow');
        } catch (Exception $e) {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }

    /**
     * Location
     */
    public function locationAction($params = [])
    {
        try {
//            $this->redirectIfNotLoggedIn();

            if ($this->request->isPost()) {
                $users = $this->request->getPost('user');
                if (is_array($users) && count($users)) {
                    // Handle Followers
                    (new UserFollower())->overrideFollowerByUserId(
                        $this->serviceManager->getAuth()->getUserId(),
                        $users
                    );
                }
            }

            $this->view->setVar('searchDisabled', true);
            $this->view->setMainView('auth/onboarding/location');
        } catch (Exception $e) {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }

    /**
     * Tables
     */
    public function tablesAction($params = [])
    {
        try {
//            $this->redirectIfNotLoggedIn();

            if ($this->request->isPost()) {
                $locations = $this->request->getPost('locations');
                if (is_array($locations) && count($locations)) {
                    // Set selected locations
                    (new UserLocations())->setUserLocationsByUserId(
                        $this->serviceManager->getAuth()->getUserId(),
                        $locations
                    );
                }
            }

            $this->view->setVar('searchDisabled', true);
            $this->view->setVar('tables', (new Tables())->findTablesAsArray($this->serviceManager->getAuth()->getUserId(), new TableFilter(), TableFlags::Published, 0, 'RAND()'));

            $this->view->setMainView('auth/onboarding/tables');
        } catch (Exception $e) {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }

    /**
     * Onboarding Finished
     */
    public function finishedAction()
    {
//        $this->redirectIfNotLoggedIn();

        $this->serviceManager->getAuth()->getUser()->setStatus(UserStatus::Confirmed)->save();

        if ($this->request->isPost()) {

            $locations = $this->request->getPost('locations');
            if (is_array($locations) && count($locations)) {
                // Set selected locations
                (new UserLocations())->setUserLocationsByUserId(
                    $this->serviceManager->getAuth()->getUserId(),
                    $locations
                );
            }
        }

        $this->response->redirect('/');
    }
}

