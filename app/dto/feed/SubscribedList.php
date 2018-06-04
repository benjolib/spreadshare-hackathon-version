<?php
namespace DS\Dto\Feed;

class SubscribedList implements FeedDto {
    use CreatedAtTrait;

    public $subscriberImage;
    public $subscriberName;
    public $tableName;
    public $numRows;
    public $subscriberCount;

    public function __construct($id, $subscriberImage, $subscriberName, $tableName, $numRows, $subscriberCount, $createdAt)
    {
        $this->subscriberImage = $subscriberImage;
        $this->subscriberName = $subscriberName;
        $this->tableName = $tableName;
        $this->numRows = $numRows;
        $this->subscriberCount = $subscriberCount;
        $this->createdAt = (new \DateTimeImmutable())->setTimestamp($createdAt);
        $this->id = $id;
    }

    public function getType(): string
    {
        return 'subscribedList';
    }
}