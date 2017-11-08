<?php
namespace DS\Component\Queue\Beanstalk;

use DS\Component\Queue\QueueInterface;
use Phalcon\Queue\Beanstalk\Extended;

/**
 * Spreadshare
 *
 * Mailing
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component\Mail
 */
class BeanstalkQueue implements QueueInterface
{
    /**
     * @var Extended
     */
    private $queue;

    /**
     * @param string $queueName
     * @param string $data
     * @param array  $options
     */
    public function queue($queueName, $data, $options = [])
    {
        $this->queue->putInTube($queueName, $data, $options);

        return $this;
    }

    public function __construct(Extended $beanstalk)
    {
        $this->queue = $beanstalk;
    }
}
