<?php

namespace DS\Model;

use Phalcon\Db;
use DS\Constants\Paging;
use Phalcon\Mvc\Model\Criteria;
use DS\Model\Helper\TableFilter;
use DS\Model\Events\TablesEvents;
use DS\Model\DataSource\TableFlags;

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
class Tables extends TablesEvents
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

        $this->query
            ->innerJoin(TableVotes::class, TableVotes::class . '.tableId = ' . Tables::class . '.id')
            ->andWhere(TableVotes::class . '.userId = :voteUserId:', ['voteUserId' => $userId])
            ->orderBy(TableVotes::class . '.createdAt DESC');

        return $this;
    }

    /**
     * Filter staff picked tables
     *
     * @return Tables
     */
    public function filterStaffPicks(): Tables
    {
        $this->initQuery();

        $this->query
            ->innerJoin(TableStaffPicks::class, TableStaffPicks::class . '.tableId = ' . Tables::class . '.id')
            ->orderBy(TableStaffPicks::class . '.createdAt DESC');

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

        $this->query
            ->innerJoin(TableSubscription::class, TableSubscription::class . '.tableId = ' . Tables::class . '.id')
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

        $this->query
            ->andWhere(Tables::class . '.ownerUserId = :ownerUserId:', ['ownerUserId' => $userId])
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

        $this->query
            ->innerJoin(TableRows::class, TableRows::class . '.tableId = ' . Tables::class . '.id')
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

        $this->query
            ->innerJoin(TableViews::class, TableViews::class . '.tableId = ' . Tables::class . '.id')
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
        if (!$this->query) {
            $this->selectTables(
                $this->serviceManager->getAuth()->getUserId(),
                new TableFilter(),
                TableFlags::Published,
                0,
                null,
                Paging::endlessScrollPortions
            );
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
    public function findTablesAsArray(
        int $userId,
        TableFilter $tableFilter,
        int $flags = TableFlags::Published,
        int $page = 0,
        $orderBy = null,
        $limit = Paging::endlessScrollPortions
    ): array
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
    public function selectTables(
        int $userId,
        TableFilter $tableFilter,
        int $flags = TableFlags::Published,
        int $page = 0,
        $orderBy = null,
        $limit = Paging::endlessScrollPortions
    ): Tables
    {
        $Locations         = Locations::class;
        $TableLocations    = TableLocations::class;
        $TableRows         = TableRows::class;
        $Tables            = Tables::class;
        $TableStaffPicks   = TableStaffPicks::class;
        $TableStats        = TableStats::class;
        $TableSubscription = TableSubscription::class;
        $TableTags         = TableTags::class;
        $TableVotes        = TableVotes::class;
        $Tags              = Tags::class;
        $Topics            = Topics::class;
        $Types             = Types::class;
        $User              = User::class;

        $this->query = self::query()
            ->columns([
                "$Tables.id",
                "$Tables.flags",
                "$Tables.title",
                "$Tables.slug",
                "$Tables.tagline",
                "$Tables.image",
                "$Tables.description",
                "$Tables.ownerUserId",
                "$Tables.featured",
                "$Tables.createdAt",
                "$Tables.topic1Id",
                "$Tables.typeId",
                "$Tables.topic2Id",

                "$User.image   AS creatorImage",
                "$User.handle  AS creatorHandle",
                "$User.name    AS creator",
                "$User.tagline AS creatorBio",

                "(SELECT $Topics.title FROM $Topics WHERE $Topics.id = $Tables.topic1Id) AS topic1",
                "(SELECT $Topics.title FROM $Topics WHERE $Topics.id = $Tables.topic2Id) AS topic2",

                "$TableStats.votesCount",
                "$TableStats.viewsCount",
                "$TableStats.commentsCount",
                "$TableStats.collaboratorCount",
                "$TableStats.contributionCount",
                "$TableStats.tokensCount",
                "$TableStats.subscriberCount",

                "$Types.title AS typeTitle",

                "(SELECT 
                    $TableStaffPicks.createdAt 
                  FROM
                    $TableStaffPicks 
                  WHERE
                    $TableStaffPicks.tableId = $Tables.id
                ) AS staffPick",

                "(SELECT
                    $TableSubscription.createdAt
                  FROM
                    $TableSubscription
                  WHERE
                        $TableSubscription.tableId = $Tables.id
                    AND $TableSubscription.userId = $userId
                ) AS userHasSubscribed",

                "(SELECT 
                    $TableVotes.createdAt 
                  FROM 
                    $TableVotes 
                  WHERE 
                        $TableVotes.tableId = $Tables.id 
                    AND $TableVotes.userId = $userId
                ) AS userHasVoted",

                "(SELECT 
                    CUSTOM_GROUP_CONCAT($Tags.title, $Tags.title, 'ASC', ', ') 
                  FROM 
                    $TableTags 
                  INNER JOIN 
                    $Tags ON $Tags.id = $TableTags.tagId 
                  WHERE 
                    $TableTags.tableId = $Tables.id
                ) AS tags",

                "(SELECT 
                    CUSTOM_GROUP_CONCAT($Locations.locationName, $Locations.locationName, 'ASC', ', ') 
                  FROM 
                    $TableLocations 
                  INNER JOIN 
                    $Locations ON $Locations.id = $TableLocations.locationId 
                  WHERE 
                    $TableLocations.tableId = $Tables.id
                ) AS locations",

                "(SELECT 
                    COUNT($TableRows.id) 
                  FROM 
                    $TableRows 
                  WHERE 
                    $TableRows.tableId = $Tables.id
                ) AS listingCount"
            ])
            ->innerJoin($TableStats, "$TableStats.tableId = $Tables.id")
            ->innerJoin($User, "$Tables.ownerUserId = $User.id")
            ->leftJoin($Types, "$Tables.typeId = $Types.id");

        if ($limit !== Paging::noPaging) {
            $this->query->limit((int) $limit + 1, $limit * $page);
        }

        if ($orderBy) {
            $this->query->orderBy($orderBy);
        }

        if (count($tableFilter->getTableIds())) {
            $this->query->inWhere(Tables::class . '.id', $tableFilter->getTableIds());
        }

        if ($flags) {
            $this->query->andWhere('flags = :flags:', ['flags' => $flags]);
        } elseif ($flags === TableFlags::All) {
            $this->query->andWhere('flags != :flags:', ['flags' => TableFlags::Deleted]);
        }

        if ($tableFilter->getTopic()) {
            $this->query->andWhere("$Tables.topic1Id = :topic: OR $Tables.topic2Id = :topic:", ['topic' => $tableFilter->getTopic()]);
        }

        if ($tableFilter->getType()) {
            $this->query->andWhere("$Tables.typeId = :type:", ['type' => $tableFilter->getType()]);
        }

        if ($tableFilter->getStaffPicks()) {
            $this->filterStaffPicks();
        }

        if ($tableFilter->getLocations() && count($tableFilter->getLocations())) {
            $this->query
                ->innerJoin("$TableLocations", "$TableLocations.tableId = $Tables.id")
                ->inWhere("$TableLocations.locationId", $tableFilter->getLocations())
                ->groupBy("$Tables.id");
        }

        if ($tableFilter->getTags() && count($tableFilter->getTags())) {
            $this->query
                ->innerJoin($TableTags, "$TableTags.tableId = $Tables.id")
                ->inWhere("$TableTags.tagId", $tableFilter->getTags())
                ->groupBy("$Tables.id");
        }

        if ($tableFilter->getDateRange()) {
            $this->query
                ->andWhere(
                "$Tables.createdAt > :dateFrom: AND $Tables.createdAt < :dateTo:",
                [
                    'dateFrom' => $tableFilter->getDateRange()->getFrom(),
                    'dateTo' => $tableFilter->getDateRange()->getTo(),
                ]
            );
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getSubscribers()
    {
        $query = $this->readQuery("
            SELECT
                user.id,
                user.handle,
                user.name,
                user.email,
                user.website,
                user.tagline,
                user.image
            FROM
                tables
            INNER JOIN
                tableSubscription ON tableSubscription.tableId = tables.id
            INNER JOIN
                user ON tableSubscription.userId = user.id
            WHERE
                tables.id = $this->id
            ");

        $query->setFetchMode(Db::FETCH_ASSOC);
        return $query->fetchAll() ?: [];
    }

    /**
     * @return array
     */
    public function getTags()
    {
        $query = $this->readQuery("
            SELECT
                tags.id,
                tags.title
            FROM
                tables
            INNER JOIN
                tableTags ON tableTags.tableId = tables.id
            INNER JOIN
                tags ON tableTags.tagId = tags.id
            WHERE
                tables.id = $this->id
            ");

        $query->setFetchMode(Db::FETCH_ASSOC);
        return $query->fetchAll() ?: [];
    }

    /**
     * @param $name
     * @param int $limit
     * @return array
     */
    public static function searchByName($name, $limit = 100)
    {
        $result = self::find([
            "conditions" => "title LIKE :name:",
            "columns"    => "id as value, title as name",
            "order"      => "title ASC",
            "limit"      => $limit,
            "bind"       => ["name" => $name . '%'],
        ]);
        return $result->toArray();
    }
}
