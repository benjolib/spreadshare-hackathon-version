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
 * @version   $Version$
 * @package   DS\Controller
 */
interface MethodInterface
{
    /**
     * Process api request
     *
     * Return value is directly sent via Response
     *
     * @return mixed
     */
    public function process();

    /**
     * Return valid md5 hashed etag for this api method
     *
     * @return mixed
     */
    public function getEtag();

}
