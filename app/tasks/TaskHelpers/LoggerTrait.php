<?php
namespace DS\Task\TaskHelpers;

use Phalcon\Logger;
use Phalcon\Logger\Adapter\File;

/**
 * Spreadshare
 *
 * Helper Task to enable logging within takss
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 */
trait LoggerTrait
{
    /**
     * @var File
     */
    protected $logger;

    /**
     * Initialize logging instance into $this->logger
     *
     * @param $path
     */
    protected function initLogger($path = '/tmp/spreadshare-task-log', $level = LOGGER::INFO)
    {
        // Initialize logging instance
        $this->logger = new File($path);
        $this->logger->setLogLevel($level);
    }

}
