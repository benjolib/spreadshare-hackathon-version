<?php

namespace DS\Controller;

use DS\Application;
use DS\Model\DataSource\TableFlags;
use DS\Model\Tables;
use DS\Model\TableStats;
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
            
            $this->view->setVar('order', $order);
            $this->view->setVar('tables', (new Tables())->findTablesAsArray($this->serviceManager->getAuth()->getUserId(), [], TableFlags::Published, 0, $orderBy));
            
            $this->view->setMainView('homepage/index');
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
    
}
