<?php

namespace DS\Events\Table;

use DS\Events\AbstractEvent;
use DS\Model\DataSource\DefaultTokenDistribution;
use DS\Model\DataSource\TokenDistributionType;
use DS\Model\TableRows;
use DS\Model\Tables;
use DS\Model\TableTokens;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Events\Table
 */
class TableRowUpvoted extends AbstractEvent
{
    
    /**
     * @param int       $userId
     * @param TableRows $row
     */
    public static function after(int $userId, TableRows $row)
    {
        $table = Tables::get($row->getTableId());
        
        /**
         * Give a token to this user for this upvote
         */
        $tableToken = new TableTokens();
        $tableToken->setUserId($table->getOwnerUserId())
            ->setTokensEarned(DefaultTokenDistribution::PerVote)
            ->setOwnership(0)
            ->setTableId($row->getTableId())
            ->setRowId($row->getId())
            ->setType(TokenDistributionType::Upvote)
            ->create();
    }
    
}