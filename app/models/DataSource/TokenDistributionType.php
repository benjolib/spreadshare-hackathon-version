<?php

namespace DS\Model\DataSource;

/**
 *
 * Spreadshare
 *
 * Default TokenDistribution
 *
 * @copyright 2017 | DS
 *
 * @version   $Version$
 * @package   DS\Model\DataSource
 */
class TokenDistributionType
{
    /**
     * Owner of the table
     */
    const Owner = 1;
    
    /**
     * Contributed to table
     */
    const Contributor = 2;
    
    /**
     * Upvoted a table or row
     */
    const Upvote = 3;
    
    /**
     * Invited another user
     */
    const Invite = 10;
}
