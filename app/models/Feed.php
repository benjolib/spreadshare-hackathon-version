<?php

namespace DS\Model;

use DateTimeImmutable;
use DS\Model\DataSource\ChangeRequestStatus;
use DS\Model\DataSource\TableFlags;
use Phalcon\Mvc\Model\Resultset\Simple;


class Feed extends \DS\Model\Base
{
    public function postsInMySubscribedLists(int $userId, int $limit, DateTimeImmutable $until, int $page) :Simple
    {
        try {
            $offset = $limit * $page;
            $query = '
        SELECT 
          tr.id as id, 
          tr.tableId as tableId, 
          tr.content as postContent, 
          tr.votesCount as postNumVotes, 
          tr.image as postImage, 
          tr.createdAt as createdAt, 
          u.name as userName,
          u.handle as userHandle, 
          t.title as tableName, 
          t.slug as tableSlug,
          u.image as userImage
        FROM ' . TableRows::class . ' tr
        INNER JOIN ' . TableSubscription::class . ' ts ON ts.tableId = tr.tableId
        INNER JOIN ' . User::class . ' u ON u.id = tr.userId
        INNER JOIN ' . Tables::class . ' t ON t.id = tr.tableId
        WHERE ts.userId = :userId:
          AND tr.createdAt < :until:
        ORDER BY tr.createdAt DESC 
        LIMIT ' . $limit.' OFFSET '.$offset;

            return $this->getModelsManager()
                ->createQuery($query)->execute([
                    'userId' => $userId,
                    'until' => $until->getTimestamp(),
                ]);

        } catch (\Exception $e) {
            var_dump($e);
            die();
        }
    }

    public function newListsFromMyFollowed(int $userId, int $limit, DateTimeImmutable $until, int $page) :Simple
    {
        try {
            $offset = $limit * $page;
            $query = '
                SELECT 
                  t.id as id, 
                  u.image as userImage, 
                  u.name as userName, 
                  u.handle as userHandle, 
                  t.id as tableId, 
                  t.slug as tableSlug,
                  t.title as tableName, 
                  t.tagline as tableTagline, 
                  t.image as tableImage,
                  t.createdAt as createdAt
                FROM '.Tables::class.' t
                    INNER JOIN '.User::class.' u ON u.id = t.ownerUserId
                    INNER JOIN '.UserFollower::class.' uf ON uf.userId = u.id
                WHERE uf.followedByUserId = :userId:
                    AND t.createdAt < :until:
                    AND t.flags = '. TableFlags::Published .'
                ORDER BY t.createdAt DESC
                LIMIT '.$limit.' OFFSET '.$offset;
            return $this->getModelsManager()
                ->createQuery($query)->execute([
                    'userId' => $userId,
                    'until' => $until->getTimestamp(),
                ]);
        } catch (\Exception $e) {
            var_dump($e);
            die();
        }
    }

    public function listsSubscribedByMyFollowed(
        int $userId,
        int $limit,
        DateTimeImmutable $until,
        int $page
    )
    {
        try {
            $offset = $limit * $page;
            $query = '
                SELECT 
                  CONCAT("c",ts.tableId,"_",ts.userId) as id,
                  u.name as userName,
                  u.image as userImage,
                  u.handle as userHandle,
                  t.id as tableId,
                  t.slug as tableSlug,
                  t.title as tableName,
                  t.tagline as tableTagline,
                  t.image as tableImage, 
                  ts.createdAt as createdAt
                FROM '.TableSubscription::class.' ts
                    INNER JOIN '.Tables::class.' t ON t.id =ts.tableId
                    INNER JOIN '.User::class.' u ON u.id = ts.userId
                    INNER JOIN '.UserFollower::class.' uf ON uf.userId = u.id
                WHERE uf.followedByUserId = :userId:
                    AND ts.createdAt < :until:
                ORDER BY ts.createdAt DESC
                LIMIT '.$limit.' OFFSET '.$offset;
            return $this->getModelsManager()
                ->createQuery($query)->execute([
                    'userId' => $userId,
                    'until' => $until->getTimestamp(),
                ]);
        } catch (\Exception $e) {
            var_dump($e);
            die();
        }
    }

    public function postsFromUsersIFollow(int $userId, int $limit, DateTimeImmutable $until, int $page, array $postsToExclude) :Simple
    {
        $printExluded = '';
        if(count($postsToExclude)>0) {
            $postsToExclude = implode(',', $postsToExclude);
            $printExluded = 'AND tr.id NOT IN ('.$postsToExclude.')';
        }
        
        
        try {
             
            $offset = $limit * $page;
            $query = '
                SELECT
                    tr.id as id,
                    tr.tableId as tableId,
                    tr.content as postContent,
                    tr.votesCount as postNumVotes,
                    tr.image as postImage,
                    tr.createdAt as createdAt,
                    u.name as userName,
                    u.handle as userHandle,
                    u.image as userImage,
                    t.title as tableName,
                    t.slug as tableSlug
                FROM '.TableRows::class.' tr
                    INNER JOIN '.User::class.' u ON u.id = tr.userId
                    INNER JOIN '.Tables::class.' t ON t.id = tr.tableId
                    INNER JOIN '.UserFollower::class.' uf ON uf.userId = u.id
                WHERE uf.followedByUserId = :userId:
                    AND tr.createdAt < :until:
                    '. $printExluded .'
                    AND t.flags = '. TableFlags::Published.'
                ORDER BY tr.createdAt DESC
                LIMIT '.$limit.' OFFSET '.$offset;
            return $this->getModelsManager()
                ->createQuery($query)->execute([
                    'userId' => $userId,
                    'until' => $until->getTimestamp(),
                ]);
        } catch (\Exception $e) {
            var_dump($e);
            die();
        }
    }

    public function votesFromUsersIFollow(int $userId, int $limit, DateTimeImmutable $until, int $page) :Simple
    {
        try {
            $offset = $limit * $page;
            $query = '
                SELECT
                    tr.id as id,
                    tr.tableId as tableId,
                    tr.content as postContent,
                    tr.votesCount as postNumVotes,
                    tr.image as postImage,
                    tr.createdAt as createdAt,
                    u.name as userName,
                    u.handle as userHandle,
                    u.image as userImage,
                    t.title as tableName,
                    t.slug as tableSlug
                FROM '.TableRows::class.' tr
                    INNER JOIN '.TableRowVotes::class.' trv ON trv.rowId = tr.id
                    INNER JOIN '.User::class.' u ON u.id = trv.userId
                    INNER JOIN '.Tables::class.' t ON t.id = tr.tableId
                    INNER JOIN '.UserFollower::class.' uf ON uf.userId = u.id
                WHERE uf.followedByUserId = :userId:
                    AND tr.createdAt < :until:
                ORDER BY tr.createdAt DESC
                LIMIT '.$limit.' OFFSET '.$offset;
            return $this->getModelsManager()
                ->createQuery($query)->execute([
                    'userId' => $userId,
                    'until' => $until->getTimestamp(),
                ]);
        } catch (\Exception $e) {
            var_dump($e);
            die();
        }

    }

    public function collabsFromUsersIFollow(int $userId, int $limit, DateTimeImmutable $until, int $page, array $postsToExclude) :Simple
    {
        $printExluded = '';
        if(count($postsToExclude)>0) {
            $postsToExclude = implode(',', $postsToExclude);
            $printExluded = 'AND tr.id NOT IN ('.$postsToExclude.')';
        }
        try {
            $offset = $limit * $page;
            $query = '
                SELECT
                    tr.id as id,
                    tr.tableId as tableId,
                    tr.content as postContent,
                    tr.votesCount as postNumVotes,
                    tr.image as postImage,
                    tr.createdAt as createdAt,
                    u.name as userName,
                    u.handle as userHandle,
                    u.image as userImage,
                    t.title as tableName,
                    t.slug as tableSlug
                FROM '.TableRows::class.' tr
                    INNER JOIN '.RequestAdd::class.' ra ON ra.user_id = tr.userId AND ra.table_id = tr.tableId AND ra.content=tr.content
                    INNER JOIN '.User::class.' u ON u.id = tr.userId
                    INNER JOIN '.Tables::class.' t ON t.id = tr.tableId
                    INNER JOIN '.UserFollower::class.' uf ON uf.userId = u.id
                WHERE uf.followedByUserId = :userId:
                    AND tr.createdAt < :until:
                    AND ra.status = '.ChangeRequestStatus::Confirmed.'
                    '. $printExluded .'
                    AND t.flags = '. TableFlags::Published.'
                ORDER BY tr.createdAt DESC
                LIMIT '.$limit.' OFFSET '.$offset;
            return $this->getModelsManager()
                ->createQuery($query)->execute([
                    'userId' => $userId,
                    'until' => $until->getTimestamp()
                ]);
        } catch (\Exception $e) {
            var_dump($e);
            die();
        }

    }

    public function numRowsFromTable($tableId):int
    {
        try {
            $query = '
                SELECT COUNT(*) as numRows FROM '.TableRows::class.' WHERE tableId = :tableId:
            ';
            $result = $this->getModelsManager()->createQuery($query)->execute([
                'tableId' => $tableId,
            ])->getFirst()['numRows'];
            return (int)$result;
        } catch (\Exception $e) {
            var_dump($e);
            die();
        }
    }

    public function numSubscribersFromTable($tableId):int
    {
        try {
            $query = '
                SELECT COUNT(*) as numSubscribers FROM '.TableSubscription::class.' WHERE tableId = :tableId:
            ';
            $result = $this->getModelsManager()->createQuery($query)->execute([
                'tableId' => $tableId,
            ])->getFirst()['numSubscribers'];
            return (int)$result;
        } catch (\Exception $e) {
            var_dump($e);
            die();
        }
    }

    public function columnsFromTable(int $tableId):array
    {
        try {
                $query = '
            SELECT title
            FROM '.TableColumns::class.'
            WHERE tableId = :tableId:
            ORDER BY position ASC
            ';

                /** @var Simple $columns */
                $columns = $this->getModelsManager()
                    ->createQuery($query)
                    ->execute([
                        'tableId' => $tableId,
                    ]);
                foreach($columns as $column) {
                    $result[] = $column->title;
                }
                return $result;

        } catch (\Exception $e) {
            var_dump($e);
            die();
        }
    }
}