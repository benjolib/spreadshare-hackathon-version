<?php

namespace DS\Dto\Feed;

use Phalcon\Mvc\Model\Row;

abstract class AbstractList implements FeedDto
{
    /**
     * @var string
     */
    public $userName;

    /**
     * @var string
     */
    public $userImage;

    /**
     * @var string
     */
    public $userHandle;

    /**
     * @var int
     */
    public $tableId;

    /**
     * @var string
     */
    public $tableName;

    /**
     * @var int
     */
    public $tableNumRows;

    /**
     * @var int
     */
    public $tableSubscriberCount;

    /**
     * @var string
     */
    public $tableTagline;

    /**
     * @var string
     */
    public $tableImage;

    /**
     * @var \DateTimeImmutable
     */
    public $createdAt;

    /**
     * @var string
     */
    public $id;

    public function __construct(array $tableStats, Row $tableData)
    {
        $this->userName = $tableData->userName;
        $this->userImage = $tableData->userImage;
        $this->userHandle = $tableData->userHandle;
        $this->tableName = $tableData->tableName;
        $this->tableNumRows = $tableStats[$tableData->tableId]['numRows'];
        $this->tableSubscriberCount = $tableStats[$tableData->tableId]['numSubscribers'];
        $this->tableTagline = $tableData->tableTagline;
        $this->tableImage = $tableData->tableImage;
        $this->createdAt = (new \DateTimeImmutable())->setTimestamp($tableData->createdAt);
        $this->tableId = $tableData->tableId;
        $this->id = $tableData->id;
    }

    abstract public function getType():string;

    public function getId():string {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}