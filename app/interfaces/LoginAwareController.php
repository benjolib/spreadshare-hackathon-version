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
interface LoginAwareController
{
    /**
     * Handle ajax request
     *
     * @return mixed
     */
    public function needsLogin();
}
