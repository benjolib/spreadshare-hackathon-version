<?php
namespace DS\Dto\Feed;

class NewList implements FeedDto {
    use CreatedAtTrait;

    public $creatorImage;
    public $creatorName;
    public $creatorHandle;
    public $tableName;
    public $numRows;
    public $subscriberCount;
    public $tagline;
    public $image;

    public function __construct(array $tableData, $newList)
    {
        $this->creatorImage = $newList->creatorImage;
        $this->creatorName = $newList->creatorName;
        $this->creatorHandle = $newList->handle;
        $this->tableName = $newList->tableName;
        $this->tagline = $newList->tagline;
        $this->image = $newList->image;
        $this->numRows = $tableData[$newList->id]['numRows'];
        $this->subscriberCount = $tableData[$newList->id]['numSubscribers'];
        $this->createdAt = (new \DateTimeImmutable())->setTimestamp($newList->createdAt);
        $this->id = $newList->id;
    }

    public function getType(): string
    {
        return 'newList';
    }
}