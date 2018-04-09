<?php

namespace DS\Controller;

use DS\Application;
use DS\Component\PrettyDateTime;
use DS\Constants\Paging;
use DS\Model\DataSource\TableFlags;
use DS\Model\DataSource\UserStatus;
use DS\Model\Helper\DateRange;
use DS\Model\Helper\TableFilter;
use DS\Model\Locations;
use DS\Model\Tables;
use DS\Model\TableStats;
use DS\Model\Tags;
use DS\Model\Topics;
use DS\Model\Types;
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
    public function indexAction($selection = 'recommended')
    {
        try {
            if ($this->serviceManager->getAuth()->loggedIn() && $this->serviceManager->getAuth()->getUser()->getStatus() == UserStatus::OnboardingIncomplete) {
                // do the onboarding
                header('Location: /signup/topics');
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

            // recommended
            $orderBy = Tables::class . '.createdAt DESC';
            $tableFilter->setStaffPicks(true);
            $this->view->setVar('selectionName', 'Recommended');

            $this->view->setVar('selection', $selection);

            $page = (int) $this->request->get('page', null, 0);
            $limit = 12;

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
                $this->view->setMainView('homepage/index');
            }
        } catch (Exception $e) {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
}
