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
class UserStatus
{
    /**
     * If dataset was created and not confirmed
     */
    const Unconfirmed = 0;

    /**
     * Normal state for a dataset
     */
    const Confirmed = 1;

    /**
     * Inactive / hidden dataset
     */
    const Deleted = 2;
}
