<?php
namespace DS\Controller\Api\Meta;

/**
 *
 * Spreadshare
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
interface RecordInterface
{
    /**
     * @return array
     */
    public function getData();

    /**
     * @return string
     */
    public function jsonSerialize();

    /**
     * @return int
     */
    public function count();
}
