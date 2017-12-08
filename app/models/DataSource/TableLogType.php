<?php

namespace DS\Model\DataSource;

/**
 *
 * Spreadshare
 *
 * ENUM status of Table log events
 *
 * @copyright 2017 | DS
 *
 * @version   $Version$
 * @package   DS\Model\DataSource
 */
class TableLogType
{
    const Created = 1;
    
    const Updated = 2;
    
    const Subscribed = 3;
    
    const Unsubscribed = 4;
    
    const Deleted = 5;
    
    const OwnerChagned = 5;
    
    const DataImported = 6;
    
    const ContributionCellDeleted = 7;
    
    const ContributionCellChanged = 8;
    
    const ContributionCellChangeRequested = 9;
    
    const ChangeRequestApproved = 10;
    
    const ChangeRequestRejected = 11;
    
    const Upvoted = 12;
    
    const Downvoted = 13;
    
    const Commented = 14;
    
    /**
     * Map string to constants
     *
     * @var array
     */
    public static $map = [
        'edits' => [
            self::ContributionCellDeleted,
            self::ContributionCellChanged,
            self::Deleted,
            self::Updated,
        ],
        'upvotes' => [
            self::Upvoted,
        ],
        'subscriptions' => [
            self::Subscribed,
        ],
        'comments' => [
            self::Commented,
        ],
    ];
}
