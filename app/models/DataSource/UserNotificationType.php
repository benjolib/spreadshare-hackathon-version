<?php

namespace DS\Model\DataSource;

/**
 *
 * Spreadshare
 *
 * ENUM status of user notification types
 *
 * @copyright 2017 | DS
 *
 * @version   $Version$
 * @package   DS\Model\DataSource
 */
class UserNotificationType
{
    /**
     * User is followed by another user
     */
    const Follow = 1;
    
    /**
     * A user's table has been subscribed
     */
    const TableSubscribed = 2;
    
}
