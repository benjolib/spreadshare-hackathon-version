<?php

namespace DS\Model\DataSource;

/**
 *
 * Spreadshare
 *
 * ENUM status of User status
 *
 * @copyright 2017 | DS
 *
 * @version   $Version$
 * @package   DS\Model\DataSource
 */
class ChangeRequestStatus
{
    /**
     * If dataset was created and not confirmed
     */
    const All = -1;
    
    /**
     * If dataset was created and not confirmed
     */
    const Unconfirmed = 0;
    
    /**
     * Confirmed state
     */
    const Confirmed = 1;
    
    /**
     * Rejected change request
     */
    const Rejected = 2;
}
