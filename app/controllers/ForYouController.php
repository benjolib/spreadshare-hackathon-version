<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;
use DS\Services\Feed as FeedService;

class ForYouController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function indexAction()
    {
        $feedDate = new \DateTimeImmutable();
        $fs = new FeedService();
        $authId = $this->serviceManager->getAuth()->getUserId();
        $postsInSubscribedLists = $fs->postsInMySubscribedLists($authId, 10, $feedDate, 0);
        $newListsFromMyFollowed = $fs->newListsFromMyFollowed($authId, 10, $feedDate, 0);
        $listsSubscribedByMyFollowed = $fs->listsSubscribedByMyFollowed($authId, 10, $feedDate, 0);
        
        $feedElements = $fs->getOrderedFeed(
            $postsInSubscribedLists->elements, 
            $newListsFromMyFollowed->elements
        );
        

        $this->view->setVar('feedElements', $feedElements);
        $this->view->setVar('feedDate', $feedDate->getTimestamp());
        //GET POSTS ON LISTS I SUBSCRIBE
        
        //GET COMMENTS ON LISTS I SUBSCRIBE
        
        // GET NEW CURATOR ON LISTS I SUBSCRIBE
        
        //GET SUBSCRIPTIONS OF USERS I FOLLOW
        
        //GET PUBLICATIONS OF USERS I FOLLOW
        
        //GET SPREADS OF USERS I FOLLOW
        
        //GET COLLABORATIONS OF USERS I FOLLOW
        
        //ORDER BY DATE
        
        //DATE OF LEAST RECENT

        $this->view->setVar('forYouActive', true);

        $this->view->setMainView('for-you/index');
    }
}
