<?php

namespace DS\Interfaces;

use DS\Model\Tables;

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
interface TableSubcontrollerInterface
{
    
    /**
     * Handle subcontroller
     *
     * @param Tables $table
     * @param int    $userId
     * @param string $param
     *
     * @return mixed
     */
    public function handle(Tables $table, int $userId, string $param);
    
    /**
     * Initialize controller
     *
     * Should be inherited from BaseController
     *
     * @return void
     */
    public function initialize();
}