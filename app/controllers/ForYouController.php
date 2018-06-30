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
        $fs = new FeedService();
        $authId = $this->serviceManager->getAuth()->getUserId();
        $postsPerPage = 10;
        if ($this->request->isAjax() && $this->request->has('page') && $this->request->has('date')) {
            $initialPage = (int)$this->request->get('page', 'int');
            $feedDate = (new \DateTimeImmutable())->setTimestamp($this->request->get('date','int'));
            $this->view->setMainView('for-you/content');
        } else {
            $initialPage = 0;
            $feedDate = new \DateTimeImmutable();
            $this->view->setMainView('for-you/index');
        }
        $postsInSubscribedLists = $fs->postsInMySubscribedLists($authId, $postsPerPage, $feedDate, $initialPage);
        $newListsFromMyFollowed = $fs->newListsFromMyFollowed($authId, $postsPerPage, $feedDate, $initialPage);
        $listsSubscribedByMyFollowed = $fs->listsSubscribedByMyFollowed($authId, $postsPerPage, $feedDate, $initialPage);
        $postsFromUsersIFollow = $fs->postsFromUsersIFollow($authId, $postsPerPage, $feedDate, $initialPage);
        $votesFromUsersIFollow = $fs->votesFromUsersIFollow($authId, $postsPerPage, $feedDate, $initialPage);
        $collabsFromUsersIFollow = $fs->collabsFromUsersIFollow($authId, $postsPerPage, $feedDate, $initialPage);

        $feedElements = $fs->getOrderedFeed(
            $postsInSubscribedLists->elements, 
            $newListsFromMyFollowed->elements,
            $listsSubscribedByMyFollowed->elements,
            $postsFromUsersIFollow->elements,
            $votesFromUsersIFollow->elements,
            $collabsFromUsersIFollow->elements
        );


        $this->view->setVar('feedElements', $feedElements);
        $this->view->setVar('feedDate', $feedDate->getTimestamp());
        $this->view->setVar('page', $initialPage);

        $this->view->setVar('forYouActive', true);
    }
}
