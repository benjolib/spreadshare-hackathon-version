<?php

namespace DS\Services;

use DateTimeImmutable;
use DS\Dto\Feed\CollabListing;
use DS\Dto\Feed\FeedDto;
use DS\Dto\Feed\SubmittedListing;
use DS\Dto\Feed\FeedElementCollection;
use DS\Dto\Feed\NewList;
use DS\Dto\Feed\NewListsCollection;
use DS\Dto\Feed\SubscribedList;
use DS\Dto\Feed\VotedListing;
use DS\Model\Feed as FeedModel;

/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 30/05/18
 * Time: 18:58
 */
class Feed
{
    protected $tableData = [];
    protected $tableColumns = [];

    public function postsInMySubscribedLists(
        int $userId,
        int $numberOfPosts,
        DateTimeImmutable $maxDate,
        int $page
    ): FeedElementCollection
    {
        $feed = new FeedModel();
        $rawListings = $feed->postsInMySubscribedLists($userId, $numberOfPosts, $maxDate, $page);

        $result = new FeedElementCollection();
        foreach ($rawListings as $rawListing) {
            if (empty($this->tableColumns[$rawListing->tableId])) {
                $this->tableColumns[$rawListing->tableId] = $feed->columnsFromTable($rawListing->tableId);
            }
            $listing = new SubmittedListing($this->tableColumns[$rawListing->tableId], $rawListing);
            $result->add($listing);
        }
        var_dump($result);die();
        return $result;
    }

    public function postsFromUsersIFollow(
        int $userId,
        int $numberOfPosts,
        DateTimeImmutable $maxDate,
        int $page,
        array $postsToExclude
    ):FeedElementCollection
    {
        $feed = new FeedModel();
        $rawListings = $feed->postsFromUsersIFollow($userId, $numberOfPosts, $maxDate, $page, $postsToExclude);

        $result = new FeedElementCollection();
        foreach ($rawListings as $rawListing) {
            if (empty($this->tableColumns[$rawListing->tableId])) {
                $this->tableColumns[$rawListing->tableId] = $feed->columnsFromTable($rawListing->tableId);
            }
            $listing = new SubmittedListing($this->tableColumns[$rawListing->tableId], $rawListing);
            $result->add($listing);
        }
        return $result;
    }

    public function newListsFromMyFollowed(
        int $userId,
        int $numberOfPosts,
        DateTimeImmutable $maxDate,
        int $page
    ): FeedElementCollection
    {
        $feed = new FeedModel();
        $newLists = $feed->newListsFromMyFollowed($userId, $numberOfPosts, $maxDate, $page);

        $result = new FeedElementCollection();
        foreach ($newLists as $newList) {
            if (empty($this->tableData[$newList->tableId])) {
                $this->tableData[$newList->tableId]['numRows'] = $feed->numRowsFromTable($newList->tableId);
                $this->tableData[$newList->tableId]['numSubscribers'] = $feed->numSubscribersFromTable($newList->tableId);
            }
            $result->add(new NewList($this->tableData, $newList));
        }
        return $result;
    }

    public function listsSubscribedByMyFollowed(
        int $userId,
        int $numberOfPosts,
        DateTimeImmutable $maxDate,
        int $page
    ):FeedElementCollection
    {
        $feed = new FeedModel();
        $subscribedLists = $feed->listsSubscribedByMyFollowed($userId, $numberOfPosts, $maxDate, $page);
        $result = new FeedElementCollection();
        foreach ($subscribedLists as $subscribedList) {
            if (empty($this->tableData[$subscribedList->tableId])) {
                $this->tableData[$subscribedList->tableId]['numRows'] = $feed->numRowsFromTable($subscribedList->tableId);
                $this->tableData[$subscribedList->tableId]['numSubscribers'] = $feed->numSubscribersFromTable($subscribedList->tableId);
            }
            $result->add(new SubscribedList($this->tableData, $subscribedList));
        }
        return $result;
    }

    public function votesFromUsersIFollow(
        int $userId,
        int $numberOfPosts,
        DateTimeImmutable $maxDate,
        int $page
    ):FeedElementCollection
    {
        $feed = new FeedModel();
        $rawListings = $feed->votesFromUsersIFollow($userId, $numberOfPosts, $maxDate, $page);

        $result = new FeedElementCollection();
        foreach ($rawListings as $rawListing) {
            if (empty($this->tableColumns[$rawListing->tableId])) {
                $this->tableColumns[$rawListing->tableId] = $feed->columnsFromTable($rawListing->tableId);
            }
            $listing = new VotedListing($this->tableColumns[$rawListing->tableId], $rawListing);
            $result->add($listing);
        }
        return $result;
    }

    public function collabsFromUsersIFollow(
        int $userId,
        int $numberOfPosts,
        DateTimeImmutable $maxDate,
        int $page,
        array $postsToExclude
    ):FeedElementCollection
    {
        $feed = new FeedModel();
        $rawListings = $feed->collabsFromUsersIFollow($userId, $numberOfPosts, $maxDate, $page, $postsToExclude);

        $result = new FeedElementCollection();
        foreach ($rawListings as $rawListing) {
            if (empty($this->tableColumns[$rawListing->tableId])) {
                $this->tableColumns[$rawListing->tableId] = $feed->columnsFromTable($rawListing->tableId);
            }
            $listing = new CollabListing($this->tableColumns[$rawListing->tableId], $rawListing);
            $result->add($listing);
        }
        return $result;
        
    }

    /**
     * @param array[] $collections
     * @return FeedDto[]
     */
    public function getOrderedFeed(array ...$collections): array
    {
        /** @var FeedDto[] $result */
        $result = array_merge(
            ...$collections
        );

        usort($result, function (FeedDto $a, FeedDto $b) {
            if ($a->getCreatedAt()->getTimestamp() > $b->getCreatedAt()->getTimestamp()) {
                return -1;
            } elseif ($a->getCreatedAt()->getTimestamp() == $b->getCreatedAt()->getTimestamp()) {
                if ($a->getType() < $b->getType()) {
                    return -1;
                } elseif ($a->getType() > $b->getType()) {
                    return 1;
                } else {
                    return $b->getId() - $a->getId();
                }
            } else {
                return 1;
            }
        });

        return $result;
    }
}