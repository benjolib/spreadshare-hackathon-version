<?php

namespace DS\Controller;

use DS\Application;
use DS\Model\Bundles;
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
     * Homepage
     */
    public function indexAction()
    {
        return $this->showStreams();
    }

    /**
     * /tag/id-or-slug-of-the-tag
     *
     * @param null $tag
     */
    public function tagAction($tag = null)
    {
        // tag may be ID or slug
        return $this->showStreams($tag);
    }

    /**
     * /bundle/id-or-slug-of-the-bundle
     *
     * @param null $bundle
     */
    public function bundleAction($bundle = null)
    {
        // bundle may be ID or slug
        return $this->showStreams(null, $bundle);
    }

    /**
     * Show Streams page accordig to hte filter provided (tag, bundle, etc)
     *
     * @param null $tag ID or slug
     * @param null $bundle ID or slug
     */
    protected function showStreams($tag = null, $bundle = null)
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

            $currentPageExplicitlyRequested = $this->request->isAjax() && $this->request->has('page');
            $currentPage = (int) $this->request->get('page', null, 0);
            $limit = 25;

            // Specufy filter on what stremas are we looking for
            $tableFilter = new TableFilter();

            if (!empty($tag)) {
                // Deal with specified tag
                $t = Tags::findByFieldValue('slug', $tag);
                if (empty($t)) {
                    // No such tags - try to fund by ID
                    $t = Tags::findFirstById($tag);
                    if (empty($t)) {
                        // No such tag - visit mainpage
                        $this->response->redirect("/", true);
                    }
                    // Redirect by slug - looks better for UI
                    $this->response->redirect("/tag/" . $t->getSlug(), true);
                }

                // Specify what exact tags to filter Streams by
                $tableFilter->setTags([$t->getId()]);
            }

            if (!empty($bundle)) {
                // Deal with specified bundle
                $b = Bundles::findByFieldValue('slug', $bundle);
                if (empty($b)) {
                    // No such bundle - try to find by ID
                    $b = Bundles::findFirstById($bundle);
                    if (empty($b)) {
                        // No such bundle - visit mainpage
                        $this->response->redirect("/", true);
                    }
                    // Redirect by slug - looks better for UI
                    $this->response->redirect("/bundle/" . $b->getSlug(), true);
                }

                // Specify what exact tags to filter Streams by
                $tableFilter->setTags($b->getTagsIds());
            }

            /*
             * This section is almost identical to the same in ExploreController
             */

            // recently-added
            $orderBy = Tables::class . ".createdAt DESC";
            $this->view->setVar('selectionName', 'Recently Added');

            // Filter tables by tableFilter
            $tables = (new Tables())
                ->findTablesAsArray(
                    $this->serviceManager->getAuth()->getUserId(),
                    $tableFilter,
                    TableFlags::Published,
                    $currentPage,
                    $orderBy,
                    $limit
                );

            // findTablesAsArray() fetches 1 more than limit requested, so we can check whether 'more' items available
            if (count($tables) > $limit) {
                $tables = array_slice($tables, 0, $limit);
                $this->view->setVar('moreItemsAvailable', true);
            } else {
                $this->view->setVar('moreItemsAvailable', false);
            }
            $this->view->setVar('tables', $tables);

            $featuredCurators = User::findByRole(UserRoles::FeaturedCurator);
            $this->view->setVar('featuredCurators', $featuredCurators->toArray(['id','name','tagline','image']));

            $featuredTags = Tags::findAllByFieldValue('featured', 1);
            $this->view->setVar('featuredTags', $featuredTags->toArray(['id','title']));

            $featuredBundles = Bundles::findAllByFieldValue('featured', 1);
            $this->view->setVar('featuredBundles', $featuredBundles->toArray(['id','title']));

            if ($currentPageExplicitlyRequested) {
                // Next page explicit request
                // Paging is done with 'load more' button - so return next page content instead of the whole page
                if (count($tables) === 0) {
                    // Return nothing if tables are empty for today.
                    $this->view->disable();
                    header('Content-Type: application/json');
                    die(json_encode([
                        'code' => 'no-results'
                    ]));
                }
                $this->view->setMainView('homepage/loadmore');
            } else if ($tag) {
                // Tagged streams load
                $this->view->setVar('tag', $tag);
                $this->view->setMainView('homepage/index');
            } else if ($bundle) {
                // Bundles streams load
                $this->view->setVar('bundle', $bundle);
                $this->view->setMainView('homepage/index');
            } else {
                // non-filtered streams load
                $this->view->setMainView('homepage/index');
            }
        } catch (Exception $e) {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
}
