<?php

namespace DS\Controller;

use DS\Api\Login;
use DS\Application;
use DS\Component\Auth;
use DS\Component\ServiceManager;
use DS\Model\DataSource\UserPasswordResetStatus;
use DS\Model\DataSource\UserStatus;
use DS\Model\Security\ChangePassword;
use DS\Model\User;
use DS\Model\UserResetPassword;
use Hybridauth\Adapter\AdapterInterface;
use Hybridauth\Exception\AuthorizationDeniedException;
use Hybridauth\Hybridauth;
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
class LoginController extends BaseController
{
    /**
     * Home
     */
    public function indexAction($params = [])
    {
        try {
            // Login request with username and password
            if ($this->request->isPost() && $this->request->getPost('username') && $this->request->getPost('password')) {
                // Login...
                $login = new Login();
                if ($login->login($this->request->getPost('username'), $this->request->getPost('password'))) {
                    header('Location: /');
                }
            }

            // Email confirmation request
            if ($this->request->get('token')) {
                $user = (new User())->findByFieldValue('emailConfirmationToken', $this->request->get('token'));

                if ($user) {
                    $this->flash->success("Account confirmed - Your account has been successfully confirmed!");
                    $user->setStatus(UserStatus::Confirmed)->setConfirmed(1)->save();
                }
            }

            // Login request callback from Twitter
            if ($this->request->get('oauth_token')) {
                return $this->loginWithTwitterAction();
            }

            // Login request callback from Facebook or Google
            if ($this->request->get('state') && $this->request->get('code')) {
                $this->loginWithFacebookAction();
                $this->loginWithGoogleAction();
            }

            /**
             * @var $auth Auth
             */
            $auth = ServiceManager::instance($this->di)->getAuth();

            // Relocate to feed view if user is logged in
            if ($auth->loggedIn()) {
                // Calling redirect only sets the 302 response status.
                $this->response->redirect('/', true, 301);

                // Better disable the view to prevent the unnecessary rendering as well.
                $this->view->disable();
            }
        } catch (Exception $e) {
            $this->flash->error($e->getMessage());
        }

        $this->view->setMainView('auth/login');

        return null;
    }

    /**
     * Forgot password
     */
    public function forgotAction($code = '')
    {
        try {
            if ($code) {
                $passwordReset = UserResetPassword::findFirstByCode($code);

                // Only allow pending request to be processed
                if ((int) $passwordReset->getStatus() !== UserPasswordResetStatus::Pending) {
                    throw new Exception('Unknown error');
                }

                if ($this->request->isGet()) {
                    if ($passwordReset) {
                        if ($passwordReset->getCreatedAt() > (time() - 60 * 60 * 24 * 14)) {
                            // Show password change form
                            $this->view->setMainView('auth/forgot/change-pass');
                            $this->view->setVar('userId', $passwordReset->getUserId());

                            return;
                        } else {
                            // Token is outdated
                            $passwordReset->setStatus(UserPasswordResetStatus::TimedOut)->save();

                            throw new \InvalidArgumentException('Your password reset token timed out.');
                        }
                    }
                } elseif ($this->request->isPost()) {
                    // Change password
                    $userId = $this->request->getPost('userId');

                    // If user id from post request matches the one from the code
                    if ($userId == $passwordReset->getUserId()) {
                        $password  = $this->request->getPost('password');
                        $password2 = $this->request->getPost('password2');

                        if ($password !== $password2) {
                            $this->view->setMainView('auth/forgot/change-pass');
                            $this->view->setVar('userId', $userId);

                            throw new \InvalidArgumentException('Passwords doesn\'t match. Please try again');
                        } else {
                            $user = User::findFirstById($userId);

                            if ($user) {
                                $changePassword = new ChangePassword();
                                if ($changePassword->changePassword($user, $password)
                                                   ->notifiyUserAboutPasswordChange()
                                                   ->hasPasswordBeenChanged()) {
                                    $passwordReset->setStatus(UserPasswordResetStatus::Changed)->save();

                                    $this->flash->success('Password changed - Your password has been successfully changed');
                                    $this->view->setMainView('auth/login');

                                    return;
                                }
                            }
                        }
                    }
                }
            }

            // Forgot password request
            elseif ($this->request->isPost()) {
                $username = $this->request->get('username');
                if ($username) {
                    $user = User::findFirstByUsernameOrEmail($username);

                    if ($user) {
                        if (UserResetPassword::factory()
                                             ->setUserId($user->getId())
                                             ->create()
                        ) {
                            $this->flash->success('Password request success - Password request successfully sent. Check your inbox.');
                        } else {
                            $this->flash->error('Password reset failed - Please try again later or contact support@aspirantic.com.');
                        }
                    }
                } else {
                    $this->flash->error('No username or email - Username or email address not found.');
                }
            }
        } catch (\Exception $e) {
            $this->flash->error($e->getMessage());
        }

        $this->view->setMainView('auth/forgot');
    }

    /**
     * Login with Twitter account
     */
    public function loginWithTwitterAction()
    {
        return $this->loginWith('Twitter');
    }

    /**
     * Login with Twitter account
     */
    public function loginWithGoogleAction()
    {
        return $this->loginWith('Google');
    }

    /**
     * Login with Facebook account
     */
    public function loginWithFacebookAction()
    {
        return $this->loginWith('Facebook');
    }

    /**
     * @param $provider
     *
     * @return null
     */
    private function loginWith($provider)
    {
        try {
            $this->view->disable();

            //Feed configuration array to Hybridauth
            $hybridauth = new Hybridauth($this->di->get('config')->get('hybridauth')->toArray());

            //Attempt to authenticate users with a provider by name
            $adapter = $hybridauth->authenticate($provider);

            //Returns a boolean of whether the user is connected with Facebook
            $isConnected = $adapter->isConnected();

            if ($isConnected) {
                $this->loginSucceeded($adapter, $provider);
            }

            //Disconnect the adapter
            $adapter->disconnect();
        } catch (AuthorizationDeniedException $e) {
            //$this->response->redirect('/');
            header('Location: /?msg=2');
        } catch (\Exception $e) {
            //$this->response->redirect('/');
            Application::instance()->log($e->getMessage(), Logger::NOTICE);
            header('Location: /');
        }

        return null;
    }

    /**
     * @param AdapterInterface $adapter
     * @param                  $provider
     */
    private function loginSucceeded(AdapterInterface $adapter, $provider)
    {
        try {
            //Retrieve the user's profile
            $userProfile = $adapter->getUserProfile();

            $name   = trim($userProfile->firstName . ' ' . $userProfile->lastName);
            $handle = $this->cleanString(strtolower($userProfile->displayName), '-');

            $user = User::addUserFromAuthService(
                $name ?: $userProfile->identifier,
                $handle ?: $userProfile->identifier,
                $userProfile->emailVerified,
                '',
                $userProfile->description,
                $userProfile->identifier,
                $userProfile->photoURL,
                $userProfile->city ? $userProfile->city : $userProfile->region,
                $userProfile->webSiteURL,
                $provider
            );

            // Redirect to topics page if the user was created
            if ((int) $user->getOperationMade() === (int) $user::OP_CREATE) {
                $redirect = '/signup/topics';
            } else {
                $redirect = '/';
            }
            $this->serviceManager->getAuth()->storeSession($user);

            header('Location: ' . $redirect);
            //$this->response->redirect('/', false);

            $this->view->disable();
        } catch (\Exception $e) {
            Application::instance()->log($e->getMessage());
        }
    }

    /**
     * @param $string
     * @param $delimiter
     *
     * @return mixed|string
     */
    protected function cleanString($string, $delimiter)
    {
        // replace non letter or non digits by -
        $string = preg_replace('#[^\pL\d]+#u', '-', $string);

        // Trim trailing -
        $string = trim($string, '-');

        $clean = preg_replace('~[^-\w]+~', '', $string);
        $clean = strtolower($clean);
        $clean = preg_replace('#[\/_|+ -]+#', $delimiter, $clean);
        $clean = trim($clean, $delimiter);

        return $clean;
    }
}
