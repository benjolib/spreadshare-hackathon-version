<?php

namespace DS\Interfaces;

use DS\Model\User;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller\User
 */
interface UserSubcontrollerInterface
{
    
    /**
     * Handle Subcontroller
     *
     * @param User $user
     *
     * @return $this
     */
    public function handle(User $user);
    
    /**
     * Initialize controller
     *
     * Should be inherited from BaseController
     *
     * @return void
     */
    public function initialize();
}