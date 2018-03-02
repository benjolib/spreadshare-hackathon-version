<?php

namespace DS\Controller;

use DS\Application;
use DS\Interfaces\LoginAwareController;
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
use Symfony\Component\VarDumper\VarDumper;

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
class TablesController
    extends IndexController
    implements LoginAwareController
{
    /**
     * @return bool
     */
    public function needsLogin()
    {
        return false;
    }

    /**
     * Table
     */
    public function indexAction($selection = 'recommended')
    {
        try
        {
            $tableFilter = new TableFilter();

            switch ($selection)
            {
                case 'recommended':
                    $orderBy = Tables::class . '.createdAt DESC';
                    $tableFilter->setStaffPicks(true);
                    $this->view->setVar('selectionName', 'Recommended');
                    break;
                case 'trending':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->setBestOf(true);
                    $tableFilter->setDateRange(DateRange::initLastDays(7));
                    $this->view->setVar('selectionName', 'Trending');
                    break;
                case 'recently-added':
                    $orderBy = Tables::class . ".createdAt DESC";
                    $this->view->setVar('selectionName', 'Recently Added');
                    break;
                case 'most-viewed':
                    $orderBy = TableStats::class . ".viewsCount DESC, " . Tables::class . '.createdAt DESC';
                    $this->view->setVar('selectionName', 'Most Viewed');
                    break;

                case 'san-francisco':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->locations = [245];
                    $this->view->setVar('selectionName', 'San Francisco');
                    break;
                case 'new-york':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->locations = [7784];
                    $this->view->setVar('selectionName', 'New York');
                    break;
                case 'london':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->locations = [1337];
                    $this->view->setVar('selectionName', 'London');
                    break;
                case 'berlin':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->locations = [2717];
                    $this->view->setVar('selectionName', 'Berlin');
                    break;

                case 'ai':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '1';
                    $this->view->setVar('selectionName', 'AI');
                    break;
                case 'blockchain':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '2';
                    $this->view->setVar('selectionName', 'Blockchain');
                    break;
                case 'bots':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '3';
                    $this->view->setVar('selectionName', 'Bots');
                    break;
                case 'business':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '4';
                    $this->view->setVar('selectionName', 'Business');
                    break;
                case 'crypto':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '5';
                    $this->view->setVar('selectionName', 'Crypto');
                    break;
                case 'culture':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '6';
                    $this->view->setVar('selectionName', 'Culture');
                    break;
                case 'design':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '7';
                    $this->view->setVar('selectionName', 'Design');
                    break;
                case 'engineering':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '8';
                    $this->view->setVar('selectionName', 'Engineering');
                    break;
                case 'finance':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '9';
                    $this->view->setVar('selectionName', 'Finance');
                    break;
                case 'fundraising':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '10';
                    $this->view->setVar('selectionName', 'Fundraising');
                    break;
                case 'growth':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '11';
                    $this->view->setVar('selectionName', 'Growth');
                    break;
                case 'hiring':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '12';
                    $this->view->setVar('selectionName', 'Hiring');
                    break;
                case 'marketing':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '13';
                    $this->view->setVar('selectionName', 'Marketing');
                    break;
                case 'media':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '14';
                    $this->view->setVar('selectionName', 'Media');
                    break;
                case 'operations':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '15';
                    $this->view->setVar('selectionName', 'Operations');
                    break;
                case 'people':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '16';
                    $this->view->setVar('selectionName', 'People');
                    break;
                case 'press':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '17';
                    $this->view->setVar('selectionName', 'Press');
                    break;
                case 'product':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '18';
                    $this->view->setVar('selectionName', 'Product');
                    break;
                case 'research':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '19';
                    $this->view->setVar('selectionName', 'Research');
                    break;
                case 'tech':
                    $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '20';
                    $this->view->setVar('selectionName', 'Tech');
                    break;
                case 'everything-else':
                      $orderBy = TableStats::class . ".subscriberCount DESC, " . Tables::class . '.createdAt DESC';
                    $tableFilter->topic = '21';
                    $this->view->setVar('selectionName', 'Everything else');
                    break;
                default:
                    break;
            }

            // Prepare date range filtering
            // switch ($date)
            // {
            //     case 'all-time':
            //         break;
            //     case 'last-90-days':
            //         $range = DateRange::initLastDays(90);
            //         break;
            //     case 'last-week':
            //         $range = DateRange::initLastWeek();
            //         break;
            //     case 'last-year':
            //         $range = DateRange::initLastYear();
            //         break;
            //     case 'yesterday':
            //         $range = DateRange::initYesterday();
            //         break;
            //     case 'today':
            //         $range = DateRange::initToday();
            //         break;
            //     default:
            //     case 'last-30-days':
            //         $range = DateRange::initLastDays(30);
            //         break;
            // }
            // $this->view->setVar('activeDateRangeString', str_replace('-', ' ', $date));
            // $this->view->setVar('activeDateFilter', $date);

            // Assign all topics and types for the sidebar
            // $this->view->setVar('topics', Topics::find());
            // $this->view->setVar('types', Types::find());

            // Prepare the table filter
            // $tableFilter            = new TableFilter();
            // $tableFilter->topic     = $this->request->get('topic', null, '');
            // $tableFilter->type      = $this->request->get('type', null, '');
            // $tableFilter->locations = $this->request->get('locations', null, []);
            // $tableFilter->tags      = $this->request->get('tags', null, []);

            // if (isset($range))
            // {
            //     $tableFilter->setDateRange($range);
            // }
            //
            // // Assign locations and tags with title and id mapping so that react-select has got a valid pre-selection
            // $locations = new Locations;
            // $this->view->setVar('filteredLocations', $locations->getByIds($tableFilter->getLocations()));
            // $tags = new Tags;
            // $this->view->setVar('filteredTags', $tags->getByIds($tableFilter->getTags()));
            //
            // $this->view->setVar('sidebarFilter', $tableFilter);
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
            if ($this->request->isAjax() && $this->request->has('page'))
            {
                if (count($tables) === 0)
                {
                  // Return nothing if tables are empty for today.
                  $this->view->disable();
                  header('Content-Type: application/json');
                  die(json_encode([
                      'code' => 'no-results ' . $page . ' ' . $limit
                  ]));
                }
                $this->view->setMainView('homepage/loadmore');
            }
            else
            {
                $this->view->setMainView('homepage/index');
            }
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
}
