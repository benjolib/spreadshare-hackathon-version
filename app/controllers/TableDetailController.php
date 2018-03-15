<?php

namespace DS\Controller;

use DS\Model\DataSource\TableFlags;
use DS\Model\Helper\TableFilter;
use DS\Model\Tables;
use DS\Api\TableContent;
use DS\Controller\Api\Meta\Records;
use DS\Model\TableComments;
use DS\Model\TableStats;
use Phalcon\Exception;

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
class TableDetailController extends BaseController
{
    /**
     * Table Detail
     */
    public function indexAction($tableId = null, $tab = 'table', $param = '')
    {
        if (!$tableId) {
            $this->response->redirect('/');

            return;
        } else {
            header('Location: /list/' . $tableId);
        }
    }
}
