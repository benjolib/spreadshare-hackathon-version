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
    
    /**
     * A user's table has been upvoted
     */
    const TableUpvoted = 3;
    
    /**
     * A user's table has been downvoted
     */
    const TableDownvoted = 4;
    
    /**
     * A user has commented in a table
     */
    const Commented = 5;
    
    /**
     * A user has changed a table
     */
    const Changed = 6;
    
    /**
     * A user has requested a changed in a table
     */
    const ChangeRequested = 7;
    
    /**
     * Change request has been confirmed
     */
    const ChangeRequestedConfirmed = 8;
    
    /**
     * Change request has been rejected
     */
    const ChangeRequestedRejected = 9;
    
    /**
     * A user's table has been unsubscribed
     */
    const TableUnsubscribed = 10;
    
    /**
     * Map string to constants
     *
     * @var array
     */
    public static $map = [
        'followers' => self::Follow,
        'comments' => self::Commented,
        'changes' => self::Changed,
        'subscribed' => self::TableSubscribed,
        'upvotes' => self::TableUpvoted,
        'change-requests' => self::ChangeRequested,
        'change-confirmed' => self::ChangeRequestedConfirmed,
        'change-rejected' => self::ChangeRequestedRejected,
    ];
    
}
