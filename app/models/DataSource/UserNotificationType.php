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
     * Map string to constants
     *
     * @var array
     */
    public static $map = [
        'followers' => self::Follow,
        'comments' => self::Commented,
        'changes' => self::Changed,
        'subscribed' => self::TableSubscribed,
        'upvoets' => self::TableUpvoted,
    ];
    
}
