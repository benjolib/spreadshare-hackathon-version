<?php

namespace DS\Task;

use DS\Listeners\ElasticSearch as ElasticSearchListener;
use DS\Task\TaskHelpers\LoggerTrait;
use DS\Modules\Bernard;

/**
 * Spreadshare
 *
 * Main Task
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 */
class QueueTask
    extends Base
{
    use LoggerTrait;

    public function mainAction()
    {

        Bernard::consume('newTable', new ElasticSearchListener);

    }

    /**
     * MainTask initialization.
     */
    public function initialize()
    {
        parent::initialize();
    }
}
