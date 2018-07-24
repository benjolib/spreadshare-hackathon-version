<?php

namespace DS\Controller;

use DS\Application;
use DS\Controller\Api\v1\Search\Get;
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
class SearchController extends BaseController
{
    /**
     * Home
     */
    public function indexAction($order = 'newest')
    {

            $this->view->setVar('query', $this->request->get('query'));

            $this->view->setMainView('search/index');
      
    }
}
