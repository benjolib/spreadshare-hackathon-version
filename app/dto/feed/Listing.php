<?php
namespace DS\Dto\Feed;

class Listing implements FeedDto {
    use CreatedAtTrait;
    
    /** @var []ListingColumn */
    public $columns;

    public $image;
    public $votesCount;
    public $submitterName;
    public $tableName;
    public $submitterImage;

    public function __construct(array $columns, $rawListing)
    {
        $content = json_decode($rawListing->content);
        foreach ($content as $key => $column) {
            $this->columns[] = new ListingColumn($columns[$key], $column->content, $column->link);
            $this->createdAt = (new \DateTimeImmutable())->setTimeStamp($rawListing->createdAt);
            $this->image = $rawListing->image;
            $this->votesCount = $rawListing->votesCount;
            $this->submitterName = $rawListing->name;
            $this->submitterHandle = $rawListing->handle;
            $this->tableName = $rawListing->title;
            $this->tableId = $rawListing->tableId;
            $this->submitterImage = $rawListing->submitterImage;
            $this->id = $rawListing->id;
        }
    }

    public function getType(): string
    {
        return 'listing';
    }
}