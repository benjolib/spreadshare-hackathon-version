<?php

namespace DS\Controller;

use DS\Application;
use DS\Model\DataSource\TableFlags;
use DS\Model\DataSource\UserRoles;
use DS\Model\DataSource\UserStatus;
use DS\Model\Helper\TableFilter;
use DS\Model\Tables;
use DS\Model\Tags;
use DS\Model\User;
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
class IndexController extends BaseController
{
    /**
     * Home
     */
    public function indexAction(
//        $selection = 'recently-added'
    $tag = null
    )
    {
        try {
            if ($this->serviceManager->getAuth()->loggedIn() && $this->serviceManager->getAuth()->getUser()->getStatus() == UserStatus::OnboardingIncomplete) {
                // do the onboarding
                header('Location: /signup');
            }

            // Message hack
            // @todo implement a better way for this
            if ($this->request->get('msg')) {
                switch ($this->request->get('msg')) {
                    case "1":
                        $this->flash->success('Table deleted - Your table has been successfully deleted.');
                        break;
                    case "2":
                        $this->flash->error('Authorization denied - Authorization request has been denied.');
                        break;
                }
            }

            $this->view->setVar('exploreActive', true);


            $tableFilter = new TableFilter();
            if (!empty($tag)) {
                $t = Tags::findByFieldValue('slug', $tag);
                if (empty($t)) {
                    /** @var Tags $t */
                    $t = Tags::findFirstById($tag);
                    $t->save();
                    $this->response->redirect("/tag/" . $t->getSlug(), true);
                    return;
                }
                $tableFilter->setTags([$t->getId()]);
            }

            // recently-added
            $orderBy = Tables::class . ".createdAt DESC";
            $this->view->setVar('selectionName', 'Recently Added');

//            $this->view->setVar('selection', $selection);

            $page = (int) $this->request->get('page', null, 0);
            $limit = 23;

            // Filter tables by tableFilter
            $tables = (new Tables())
                ->findTablesAsArray(
                    $this->serviceManager->getAuth()->getUserId(),
                    $tableFilter,
                    TableFlags::Published,
                    $page,
                    $orderBy,
                    $limit
                );

            // we fetch 1 more than limit so we can check this
            if (count($tables) > $limit) {
                $tables = array_slice($tables, 0, $limit);
                $this->view->setVar('moreToLoad', true);
            } else {
                $this->view->setVar('moreToLoad', false);
            }

            $this->view->setVar('tables', $tables);

            $featuredCurators = User::findByRole(UserRoles::FeaturedCurator);
            $this->view->setVar('featuredCurators', $featuredCurators->toArray(['id','name','tagline','image']));

            $featuredTags = Tags::findAllByFieldValue('featured', 1);
            $this->view->setVar('featuredTags', $featuredTags->toArray(['id','title']));
            // Paging instead of returning the whole page
            if ($this->request->isAjax() && $this->request->has('page')) {
                if (count($tables) === 0) {
                    // Return nothing if tables are empty for today.
                    $this->view->disable();
                    header('Content-Type: application/json');
                    die(json_encode([
                      'code' => 'no-results'
                  ]));
                }
                $this->view->setMainView('homepage/loadmore');
            } else {
                 if (!empty($tag)) {
                     $this->view->setVar('tag', $tag);
                    $this->view->setMainView('homepage/index');
                 }else {
                    $this->view->setMainView('homepage/index');
                 }
                
            }
        } catch (Exception $e) {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
}
