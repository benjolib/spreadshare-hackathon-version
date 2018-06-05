<?php
namespace DS\Dto\Feed;

abstract class AbstractListing implements FeedDto {

    public $id;
    public $tableId;
    public $tableName;
    public $postNumVotes;
    public $postImage;
    public $userName;
    public $userHandle;
    public $userImage;
    public $createdAt;
    
    /** @var []ListingColumn */
    public $columns;

    public function __construct(array $columns, $rawListing)
    {
        $content = json_decode($rawListing->postContent);
        foreach ($content as $key => $column) {
            $this->id = $rawListing->id;
            $this->tableId = $rawListing->tableId;
            $this->tableName = $rawListing->tableName;
            $this->postNumVotes = $rawListing->postNumVotes;
            $this->postImage = $rawListing->postImage;
            $this->userName = $rawListing->userName;
            $this->userHandle = $rawListing->userHandle;
            $this->userImage = $rawListing->userImage;
            $this->createdAt = (new \DateTimeImmutable())->setTimeStamp($rawListing->createdAt);
            $this->columns[] = new ListingColumn($columns[$key], $column->content, $column->link);
        }
    }

    abstract public function getType(): string;

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getId(): string
    {
        return $this->id;
    }
}