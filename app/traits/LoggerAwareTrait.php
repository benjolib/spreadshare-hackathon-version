<?php
namespace DS\Traits;

use Phalcon\Logger\AdapterInterface;

/**
 * Spreadshare Application
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
trait LoggerAwareTrait
{
    /**
     * The logger instance.
     *
     * @var AdapterInterface
     */
    protected $logger;

    /**
     * Sets a logger.
     *
     * @param AdapterInterface $logger
     *
     * @return $this
     */
    public function setLogger(AdapterInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }
}
