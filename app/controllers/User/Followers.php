<?php

namespace DS\Controller\User;

use DS\Controller\BaseController;
use DS\Interfaces\UserSubcontrollerInterface;
use DS\Model\User;
use DS\Model\UserFollower;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller\User
 */
class Followers
    extends BaseController
    implements UserSubcontrollerInterface
{
    
    /**
     * Handle Subcontroller
     *
     * @param User $user
     *
     * @return $this
     */
    public function handle(User $user)
    {
        $this->view->setVar('users', UserFollower::findAllFollower($user->getId()));
        
        return $this;
    }
}