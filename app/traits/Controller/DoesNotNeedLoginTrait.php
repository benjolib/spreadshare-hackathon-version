<?php
namespace DS\Traits\Controller;

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
trait DoesNotNeedLoginTrait
{
    /**
     * @return bool
     */
    public function needsLogin()
    {
        return false;
    }
}
