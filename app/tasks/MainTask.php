<?php

namespace DS\Task;

use DS\Task\TaskHelpers\LoggerTrait;

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
class MainTask
    extends Base
{
    use LoggerTrait;
    
    public function mainAction()
    {
        echo "Hello World";
    }
    
    /**
     * MainTask initialization.
     */
    public function initialize()
    {
        parent::initialize();
    }
}
