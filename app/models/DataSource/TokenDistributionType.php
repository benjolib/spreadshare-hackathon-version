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
     * Invited another user
     */
    const Invite = 2;
    
}
