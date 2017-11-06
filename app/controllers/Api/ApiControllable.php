<?php
namespace DS\Controller\Api;

/**
 *
 * Spreadshare
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version $Version$
 * @package DS\Controller
 */
interface ApiControllable
{

    /**
     * Process api request
     *
     * Return value is directly sent to the requestor
     *
     * @return mixed
     */
    public function process();

}
