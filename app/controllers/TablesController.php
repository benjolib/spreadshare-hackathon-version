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
    public function indexAction($order = 'most-upvoted', $date = 'last-30-days')
    {
        try
        {
            // Prepare ordering
            switch ($order)
            {
                case 'newest':
                    $orderBy = Tables::class . '.createdAt DESC';
                    break;
                case 'most-viewed':
                    $orderBy = TableStats::class . ".viewsCount DESC";
                    break;
                case 'most-contributed':
                    $orderBy = TableStats::class . ".contributionCount DESC";
                    break;
                default:
                case 'most-upvoted':
                    $orderBy = TableStats::class . ".votesCount DESC";
                    break;
            }

            // Prepare date range filtering
            switch ($date)
            {
                case 'all-time':
                    break;
                case 'last-90-days':
                    $range = DateRange::initLastDays(90);
                    break;
                case 'last-week':
                    $range = DateRange::initLastWeek();
                    break;
                case 'last-year':
                    $range = DateRange::initLastYear();
                    break;
                case 'yesterday':
                    $range = DateRange::initYesterday();
                    break;
                case 'today':
                    $range = DateRange::initToday();
                    break;
                default:
                case 'last-30-days':
                    $range = DateRange::initLastDays(30);
                    break;
            }
            $this->view->setVar('activeDateRangeString', str_replace('-', ' ', $date));
            $this->view->setVar('activeDateFilter', $date);

            // Assign all topics and types for the sidebar
            $this->view->setVar('topics', Topics::find());
            $this->view->setVar('types', Types::find());

            // Prepare the table filter
            $tableFilter            = new TableFilter();
            $tableFilter->topic     = $this->request->get('topic', null, '');
            $tableFilter->type      = $this->request->get('type', null, '');
            $tableFilter->locations = $this->request->get('locations', null, []);
            $tableFilter->tags      = $this->request->get('tags', null, []);

            if (isset($range))
            {
                $tableFilter->setDateRange($range);
            }

            // Assign locations and tags with title and id mapping so that react-select has got a valid pre-selection
            $locations = new Locations;
            $this->view->setVar('filteredLocations', $locations->getByIds($tableFilter->getLocations()));
            $tags = new Tags;
            $this->view->setVar('filteredTags', $tags->getByIds($tableFilter->getTags()));

            $this->view->setVar('sidebarFilter', $tableFilter);
            $this->view->setVar('order', $order);

            // Filter tables by tableFilter
            $tables = (new Tables())
                ->findTablesAsArray(
                    $this->serviceManager->getAuth()->getUserId(),
                    $tableFilter,
                    TableFlags::Published,
                    (int) $this->request->get('page', null, 0),
                    $orderBy
                );
            $this->view->setVar('tables', $tables);

            // Paging instead of returning the whole page
            if ($this->request->isAjax() && $this->request->has('page'))
            {
                if (count($tables) === 0)
                {
                    echo '';
                    die;
                }
                $this->view->setMainView('tables/tables');
            }
            else
            {
                $this->view->setMainView('tables/index');
            }
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
}
