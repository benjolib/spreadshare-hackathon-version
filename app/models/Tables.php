<?php

namespace DS\Model;

use DS\Constants\Paging;
use DS\Model\DataSource\TableFlags;
use DS\Model\Events\TablesEvents;
use DS\Model\Helper\TableFilter;
use Phalcon\Mvc\Model\Criteria;

/**
 * Tables
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 *
 * @method static self findFirstById(int $id)
 */
class Tables
    extends TablesEvents
{
    /**
     * @var Criteria
     */
    private $query;
    
    /**
     * @return Criteria
     */
    public function getQuery(): Criteria
    {
        return $this->query;
    }
    
    /**
     * Filter for upvotes by $userId. Better call selectTables() first!
     *
     * @param int $userId
     *
     * @return Tables
     */
    public function filterUpvoted(int $userId): Tables
    {
        $this->initQuery();
        
        $this->query->innerJoin(TableVotes::class, TableVotes::class . '.tableId = ' . Tables::class . '.id')
                    ->andWhere(TableVotes::class . '.userId = :voteUserId:', ['voteUserId' => $userId])
                    ->orderBy(TableVotes::class . '.createdAt DESC');
        
        return $this;
    }
    
    /**
     * Filter for subscriptions by $userId. Better call selectTables() first!
     *
     * @param int $userId
     *
     * @return Tables
     */
    public function filterSubscribed(int $userId): Tables
    {
        $this->initQuery();
        
        $this->query->innerJoin(TableSubscription::class, TableSubscription::class . '.tableId = ' . Tables::class . '.id')
                    ->andWhere(TableSubscription::class . '.userId = :subscriptionUserId:', ['subscriptionUserId' => $userId])
                    ->orderBy(TableSubscription::class . '.createdAt DESC');
        
        return $this;
    }
    
    /**
     * Filter Tables that are owned by $userId. Better call selectTables() first!
     *
     * @param int $userId
     *
     * @return Tables
     */
    public function filterOwned(int $userId): Tables
    {
        $this->initQuery();
        
        $this->query->andWhere(Tables::class . '.ownerUserId = :ownerUserId:', ['ownerUserId' => $userId])
                    ->orderBy(Tables::class . '.id DESC');
        
        return $this;
    }
    
    /**
     * Filter Tables where $userId did any contribution. Better call selectTables() first!
     *
     * @param int $userId
     *
     * @return Tables
     */
    public function filterContributed(int $userId): Tables
    {
        $this->initQuery();
        
        $this->query->innerJoin(TableRows::class, TableRows::class . '.tableId = ' . Tables::class . '.id')
                    ->leftJoin(TableCells::class, TableCells::class . '.rowId = ' . TableRows::class . '.id')
                    ->andWhere(TableCells::class . '.userId = :cellUserId: OR ' . TableRows::class . '.userId = :rowUserId:', ['cellUserId' => $userId, 'rowUserId' => $userId])
                    ->groupBy(Tables::class . '.id')
                    ->orderBy(Tables::class . '.id DESC');
        
        return $this;
    }
    
    /**
     * Filter Tables that $userId visited lately. Better call selectTables() first!
     *
     * @param int $userId
     *
     * @return Tables
     */
    public function filterHistory(int $userId): Tables
    {
        $this->initQuery();
        
        $this->query->innerJoin(TableViews::class, TableViews::class . '.tableId = ' . Tables::class . '.id')
                    ->andWhere(TableViews::class . '.userId = :viewUserId:', ['viewUserId' => $userId])
                    ->groupBy(Tables::class . '.id')
                    ->orderBy(TableViews::class . '.createdAt DESC');
        
        return $this;
    }
    
    /**
     * Initialize query instance
     */
    private function initQuery()
    {
        if (!$this->query)
        {
            $this->selectTables($this->serviceManager->getAuth()->getUserId(), new TableFilter(), $flags = TableFlags::Published, 0, null, Paging::endlessScrollPortions);
        }
    }
    
    /**
     * @param int         $userId
     * @param TableFilter $tableFilter
     * @param int         $flags
     * @param int         $page
     * @param null        $orderBy
     * @param int         $limit
     *
     * @return array
     */
    public function findTablesAsArray(int $userId, TableFilter $tableFilter, int $flags = TableFlags::Published, int $page = 0, $orderBy = null, $limit = Paging::endlessScrollPortions): array
    {
        $this->selectTables($userId, $tableFilter, $flags, $page, $orderBy, $limit);
        
        return $this->query->execute()->toArray() ?: [];
    }
    
    /**
     * @param int[] $tableIds
     * @param int   $userId User id is only used for votecounting, not for filtering
     * @param int   $page
     * @param int   $limit
     *
     * @return self
     */
    public function selectTables(int $userId, TableFilter $tableFilter, int $flags = TableFlags::Published, int $page = 0, $orderBy = null, $limit = Paging::endlessScrollPortions): Tables
    {
        $this->query = self::query()
                           ->columns(
                               [
                                   Tables::class . ".id",
                                   Tables::class . ".title",
                                   Tables::class . ".tagline",
                                   Tables::class . ".ownerUserId",
                                   User::class . ".image as creatorImage",
                                   User::class . ".name as creator",
                                   Tables::class . ".createdAt",
                                   Tables::class . ".topic1Id",
                                   "(SELECT " . Topics::class . ".title FROM " . Topics::class . " WHERE " . Topics::class . ".id = " . Tables::class . ".topic1Id) AS topic1",
                                   Tables::class . ".topic2Id",
                                   "(SELECT " . Topics::class . ".title FROM " . Topics::class . " WHERE " . Topics::class . ".id = " . Tables::class . ".topic2Id) AS topic2",
                                   TableStats::class . ".votesCount",
                                   TableStats::class . ".viewsCount",
                                   TableStats::class . ".commentsCount",
                                   TableStats::class . ".collaboratorCount",
                                   TableStats::class . ".contributionCount",
                                   TableStats::class . ".tokensCount",
                                   TableStats::class . ".subscriberCount",
                                   Types::class . ".title as typeTitle",
                                   "(SELECT " . TableVotes::class . ".createdAt FROM " . TableVotes::class . " WHERE " . TableVotes::class . ".tableId = " . Tables::class . ".id AND " . TableVotes::class . ".userId = " . $userId . ") as userHasVoted",
                                   "(SELECT CUSTOM_GROUP_CONCAT(" . Tags::class . ".title, " . Tags::class . ".title, 'ASC', ', ') FROM " . TableTags::class . " INNER JOIN " . Tags::class . " ON " . Tags::class . ".id = " . TableTags::class . ".tagId WHERE " . TableTags::class . ".tableId = " . Tables::class . ".id) as tags",
                                   "(SELECT CUSTOM_GROUP_CONCAT(" . Locations::class . ".locationName, " . Locations::class . ".locationName, 'ASC', ', ') FROM " . TableLocations::class . " INNER JOIN " . Locations::class . " ON " . Locations::class . ".id = " . TableLocations::class . ".locationId WHERE " . TableLocations::class . ".tableId = " . Tables::class . ".id) as locations",
                               ]
                           )
                           ->innerJoin(TableStats::class, TableStats::class . '.tableId = ' . Tables::class . '.id')
                           ->innerJoin(User::class, Tables::class . '.ownerUserId = ' . User::class . '.id')
                           ->leftJoin(Types::class, Tables::class . '.typeId = ' . Types::class . '.id')
                           ->limit((int) $limit, (int) Paging::endlessScrollPortions * $page);
        
        if ($orderBy)
        {
            $this->query->orderBy($orderBy);
        }
        
        if (count($tableFilter->getTableIds()))
        {
            $this->query->inWhere(Tables::class . '.id', $tableFilter->getTableIds());
        }
        
        if ($flags)
        {
            $this->query->andWhere('flags = :flags:', ['flags' => $flags]);
        }
        
        if ($tableFilter->getTopic())
        {
            $this->query->andWhere(Tables::class . '.topic1Id = :topic: OR ' . Tables::class . '.topic2Id = :topic:', ['topic' => $tableFilter->getTopic()]);
        }
        
        if ($tableFilter->getType())
        {
            $this->query->andWhere(Tables::class . '.typeId = :type:', ['type' => $tableFilter->getType()]);
        }
        
        if ($tableFilter->getLocations() && count($tableFilter->getLocations()))
        {
            $this->query->innerJoin(TableLocations::class, TableLocations::class . '.tableId = ' . Tables::class . '.id')
                        ->inWhere(TableLocations::class . '.locationId', $tableFilter->getLocations())
                        ->groupBy(Tables::class . '.id');
            
        }
        
        if ($tableFilter->getTags() && count($tableFilter->getTags()))
        {
            $this->query->innerJoin(TableTags::class, TableTags::class . '.tableId = ' . Tables::class . '.id')
                        ->inWhere(TableTags::class . '.tagId', $tableFilter->getTags())
                        ->groupBy(Tables::class . '.id');
            
        }
        
        return $this;
    }
}
