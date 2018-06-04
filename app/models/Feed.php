<?php

namespace DS\Model;

use DateTimeImmutable;
use Phalcon\Mvc\Model\Resultset\Simple;


class Feed extends \DS\Model\Base
{
    public function postsInMySubscribedLists(int $userId, int $limit, DateTimeImmutable $until, int $page) :Simple
    {
        try {
            $offset = $limit * $page;
            $query = '
        SELECT tr.id, tr.tableId, tr.content, tr.votesCount, tr.image, tr.createdAt, u.name,u.handle, t.title, 
          u.image as submitterImage
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
                SELECT u.image as creatorImage, u.name as creatorName, u.handle as handle, t.title as tableName, t.createdAt, t.id, t.tagline, t.image
                FROM '.Tables::class.' t
                    INNER JOIN '.User::class.' u ON u.id = t.ownerUserId
                    INNER JOIN '.UserFollower::class.' uf ON uf.userId = u.id
                WHERE uf.followedByUserId = :userId:
                    AND t.createdAt < :until:
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
                SELECT u.image as subscriberImage, u.name as subscriberName,
                    t.id as tableId, t.title as tableName, 
                    ts.createdAt as createdAt, CONCAT(ts.tableId,"_",ts.userId) as id
                FROM '.TableSubscription::class.' ts
                    INNER JOIN '.Tables::class.' t ON t.id =ts.tableId
                    INNER JOIN '.User::class.' u ON u.id = ts.userId
                    INNER JOIN '.UserFollower::class.' uf ON uf.userId = u.id
                WHERE uf.followedByUserId = :userId:
                    AND ts.createdAt < :until:
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