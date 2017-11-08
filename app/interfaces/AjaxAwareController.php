<?php
namespace DS\Interfaces;

/**
 * Spreadshare
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version $Version$
 * @package DS\Interfaces
 */
interface AjaxAwareController
{
    /**
     * Handle ajax request
     *
     * @return mixed
     */
    public function ajaxRequest($params);

    /**
     * Handle regular index request
     *
     * @return mixed
     */
    public function indexRequest($params);
}
