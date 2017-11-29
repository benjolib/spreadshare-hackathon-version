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
class DefaultTokenDistribution
{
    /**
     * Percentage of tokens a table owner earns
     */
    const OwnershipPercentage = 2.5;
    
    /**
     * Amount of tokens a user gets for creating a table
     */
    const TableCreation = 0;
    
    /**
     * Amount of tokens users receive per table view
     */
    const PerView = .01;
    
    /**
     * Amount of tokens users receive per table or table row vote
     */
    const PerVote = 1;
}
