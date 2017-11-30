<?php

namespace DS\Traits\Model;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Interfaces
 */
trait ClearByTableIdTrait
{
    /**
     * @param int $tableId
     *
     * @return bool
     */
    public function clear(int $tableId)
    {
        if ($tableId > 0)
        {
            // Remove all followers
            return $this->getWriteConnection()
                        ->delete($this->getSource(), "tableId = '{$tableId}'");
        }
        
        return false;
    }
}
