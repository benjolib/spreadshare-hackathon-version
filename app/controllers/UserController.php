<?php

namespace DS\Controller;

use DS\Model\Helper\TableFilter;
use DS\Model\Tables;
use DS\Model\User;
use DS\Model\UserConnections;
use DS\Model\UserFollower;
use DS\Model\UserSettings;
use DS\Model\Wallet;

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
class UserController
    extends BaseController
{
    /**
     * Home
     */
    public function indexAction($params = [])
    {
    
    }
    
    /**
     * User
     */
    public function profileAction($handle = '', $page = 'upvoted')
    {
        try
        {
            $user = User::findByFieldValue('handle', $handle);
            
            if (!$user)
            {
                header('Location: /');
            }
            elseif ($user && $user->getId())
            {
                
                $connectionList = [];
                $connections    = UserConnections::findByFieldValue('userId', $user->getId());
                if ($connections)
                {
                    foreach ($connections->getConnectionList() as $connection)
                    {
                        $connectionLink = call_user_func([$connections, 'get' . ucfirst($connection)]);
                        
                        if ($connectionLink)
                        {
                            if ($connection == 'fivehundretpx')
                            {
                                $connection = '500px';
                            }
                            
                            $connectionList[] = [
                                'name' => $connection,
                                'link' => $connectionLink,
                            ];
                        }
                    }
                }

                $createdLists = (new Tables())
                    ->selectTables($this->serviceManager->getAuth()->getUserId(), new TableFilter())
                    ->filterOwned($user->getId())->getQuery()->execute()->toArray() ?: [];


                $this->view->setVar('createdLists', $createdLists);

                $this->view->setVar('connections', $connectionList);
                
                $this->view->setVar('numFollowing', UserFollower::countFollowing($user->getId()));
                $this->view->setVar('numFollowers', UserFollower::countFollowers($user->getId()));
                $this->view->setVar('currentPage', $page);
                $this->view->setVar('profile', $user);
                $this->view->setVar('settings', UserSettings::get($user->getId(), 'userId'));
                $this->view->setVar('userWallet', Wallet::get($user->getId(), 'userId'));
                $this->view->setMainView('user/profile');
                
                $subClass = "DS\\Controller\\User\\" . ucfirst($page);
                if (class_exists($subClass))
                {
                    /**
                     * @var \DS\Interfaces\UserSubcontrollerInterface $subController
                     */
                    $subController = new $subClass();
                    if (is_a($subController, 'DS\Interfaces\UserSubcontrollerInterface'))
                    {
                        $subController->initialize();
                        $subController->handle($user);
                    }
                }
            }
        }
        catch (\Exception $e)
        {
            $this->serviceManager->getLogger()->error($e->getMessage());
        }
    }

    public function profileUpdateAction()
    {
        if ($this->request->isPost()) {
            $user = $this->serviceManager->getAuth()->getUser();
            if ($this->request->hasFiles()) {
                $file = $this->request->getUploadedFiles()[0];
                $path = ROOT_PATH.'public/userimages/';
                $file->moveTo($path.$user->getId().'.'.$file->getExtension());
                $user->setImage('/userimages/'.$user->getId().'.'.$file->getExtension());
            }
            $user->setName($this->request->get('name'))
                ->setTagline($this->request->get('tagline'))
                ->save();
            $this->response->redirect('/profile/'.$user->getHandle(),true);
        }

    }
}
