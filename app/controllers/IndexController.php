<?php

namespace DS\Controller;

use DS\Application;
use DS\Model\DataSource\TableFlags;
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
class IndexController
    extends BaseController
{
    /**
     * Home
     */
    public function indexAction($order = 'newly-added')
    {
        try
        {
            // Prepare ordering
            switch ($order)
            {
                case 'most-upvoted':
                    $orderBy = TableStats::class . ".votesCount DESC";
                    break;
                case 'most-viewed':
                    $orderBy = TableStats::class . ".viewsCount DESC";
                    break;
                case 'most-contributed':
                    $orderBy = TableStats::class . ".contributionCount DESC";
                    break;
                default:
                case 'newly-added':
                    $orderBy = 'createdAt DESC';
                    break;
            }
            
            // Assign all topics and types for the sidebar
            $this->view->setVar('topics', Topics::find());
            $this->view->setVar('types', Types::find());
            
            // Prepare the table filter
            $tableFilter            = new TableFilter();
            $tableFilter->topic     = $this->request->get('topic', null, '');
            $tableFilter->type      = $this->request->get('type', null, '');
            $tableFilter->locations = $this->request->get('locations', null, []);
            $tableFilter->tags      = $this->request->get('tags', null, []);
            
            // Assign locations and tags with title and id mapping so that react-select has got a valid pre-selection
            $locations = new Locations;
            $this->view->setVar('filteredLocations', $locations->getByIds($tableFilter->getLocations()));
            $tags = new Tags;
            $this->view->setVar('filteredTags', $tags->getByIds($tableFilter->getTags()));
            
            $this->view->setVar('sidebarFilter', $tableFilter);
            $this->view->setVar('order', $order);
            
            // Filter tables by tableFilter
            $this->view->setVar(
                'tables',
                (new Tables())
                    ->findTablesAsArray(
                        $this->serviceManager->getAuth()->getUserId(),
                        $tableFilter,
                        TableFlags::Published,
                        0,
                        $orderBy
                    )
            );
            
            $this->view->setMainView('homepage/index');
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
    
}
