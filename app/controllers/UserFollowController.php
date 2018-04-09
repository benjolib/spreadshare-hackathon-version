<?php

namespace DS\Controller;

use DS\Model\User;
use DS\Model\UserFollower;
use DS\Interfaces\LoginAwareController;

class UserFollowController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function followAction($user)
    {
        $follower = $this->serviceManager->getAuth()->getUserId();

        $usertofollow = User::find($user);

        // Check if table exists
        if ($usertofollow->count() === 0) {
            $this->flash->error('User not found - The user you are trying to follow does not exist');
            $this->_redirectBack();
        }

        $follow = new UserFollower();
        $follow->toggleFollow($user, $follower);

        $this->flash->success('Follow success - You are now following this user');
        $this->_redirectBack();
    }
}
