<?php

namespace DS\Component;

use DS\Application;
use DS\Component\Session\Adapter\RedisAdapter;
use DS\Model\Abstracts\AbstractUser;
use DS\Model\User;
use Phalcon\DI\InjectionAwareInterface;
use Phalcon\DiInterface;
use Phalcon\Mvc\User\Component;

/**
 * Spreadshare
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component
 *
 * @property RedisAdapter $session
 */
class Auth
    extends Component
    implements InjectionAwareInterface
{
    
    /**
     * Id of current user
     *
     * @var int
     */
    public $userId;
    
    /**
     * User Model
     *
     * @var User
     */
    protected $user;
    
    /**
     * Remember authenticated session for 15 days
     *
     * @var int
     */
    public $rememberForDays = 15;
    
    /**
     * Return internal phalcon security component
     *
     * @return \Phalcon\Security
     */
    public function getSecurity()
    {
        return $this->security;
    }
    
    /**
     * @return int
     */
    public function getRememberForDays()
    {
        return $this->rememberForDays;
    }
    
    /**
     * @param int $rememberForDays
     *
     * @return $this
     */
    public function setRememberForDays($rememberForDays)
    {
        $this->rememberForDays = $rememberForDays;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
    
    /**
     * @param int $userId
     *
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->userId = (int) $userId;
        
        return $this;
    }
    
    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * @param User $user
     *
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->userId = (int) $user->getId();
        $this->user   = $user;
        
        return $this;
    }
    
    /**
     * Load user object
     *
     * @return $this
     */
    private function loadUser()
    {
        if ($this->userId > 0)
        {
            $this->user = User::findFirstById($this->userId);
        }
        else
        {
            $this->user = null;
        }
        
        return $this;
    }
    
    /**
     * Login
     *
     * @param AbstractUser $user
     *
     * @return $this
     */
    public function storeSession(AbstractUser $user)
    {
        try
        {
            ServiceManager::instance()->getAuth()->session->start();
            ServiceManager::instance()->getAuth()->session->remove('uid');
            ServiceManager::instance()->getAuth()->session->set('uid', $user->getId());
            
            $this->session->regenerateId(true);
            
            if ($user->getLastSessionId())
            {
                // Set session to last session id so that the old session gets removed
                // $this->session->setId($user->getLastSessionId());
            }
            
            // $this->removeSession();
            
            // Set user for internal usage
            $this->userId = (int) $user->getId();
            
            // Store current user id in session
            $this->session->set('uid', $this->userId);
            
            // Set last session id, store user in member variable and push user's new session id to db
            $this->user = $user->setLastSessionId($this->session->getId());
            $this->user->save();
        }
        catch (\Exception $e)
        {
            Application::instance()->log($e->getMessage());
        }
        
        return $this;
    }
    
    /**
     * Logout
     *
     * @return $this
     */
    public function removeSession()
    {
        try
        {
            // Remove user from internal auth store
            $this->userId = 0;
            $this->user   = null;
            
            // Remove user id explicitly just to be sure
            $this->session->remove('uid');
            
            // Then remove everything else
            $this->session->destroy(true);
            
            // Remove session token from cookies
            $this->cookies->set('sessToken', '')->send();
            
            // This should fix "session_regenerate_id(): Session object destruction failed. ID: user (path: )"
            // @see https://sentry.io/coders/coders/issues/243834480/
            // Phalcon 3.0.x may fixed this as well: https://github.com/phalcon/cphalcon/pull/12206 so i am leaving the if commented for now
            // if ($this->session->isStarted() && $this->session->status() === SessionAdapter::SESSION_ACTIVE)
            {
                // Generate new session id
                $this->session->regenerateId(true);
            }
        }
        catch (\Exception $e)
        {
            Application::instance()->log($e->getMessage());
        }
        
        return $this;
    }
    
    /**
     * Session token
     *
     * @return string
     */
    public function getSessionToken()
    {
        return $this->session->getId();
    }
    
    /**
     * User is logged in
     */
    public function loggedIn()
    {
        return ($this->userId > 0 && $this->user);
    }
    
    /**
     * Update last login date of the user that has logged in
     *
     * @return $this
     */
    public function updateLastLogin()
    {
        if ($this->user)
        {
            $this->user->setLastLogin(time())->save();
        }
        
        return $this;
    }
    
    /**
     * Auth constructor.
     *
     * @param DiInterface $di
     */
    public function __construct(DiInterface $di)
    {
        $this->setDI($di);
        $this->session = $di->get('session');
        
        if (isset($this->cookies) && $this->cookies)
        {
            $this->cookies->useEncryption(true);
        }
        
        if (!$this->session->isStarted())
        {
            if (!$this->session->start())
            {
                ServiceManager::instance($this->getDI())->getLogger()->warning(sprintf('Could not start session (%s)', $this->getSessionToken()));
            }
        }
        
        // This is responsible for checking if a user is logged in or not
        $this->userId = (int) $this->session->get('uid');
        $this->loadUser();
    }
}
