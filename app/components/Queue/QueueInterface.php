<?php
namespace DS\Component\Queue;

/**
 * Spreadshare
 *
 * Queueing
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component\Mail
 */
interface QueueInterface
{
    /**
     * @param string $queueName
     * @param string $data
     * @param array  $options
     */
    public function queue($queueName, $data, $options = []);
}
