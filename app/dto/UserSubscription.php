<?php

namespace DS\Dto;

class UserSubscription {
    public $userId;
    public $tableId;
    public $title;
    public $type;
    public $numSubscribers;
    public $tagline;

    public function __construct($userId, $tableId, $title, $tagline, $type, $numSubscribers)
    {
        $this->userId = $userId;
        $this->tableId = $tableId;
        $this->title = $title;
        $this->type = $type;
        $this->numSubscribers = $numSubscribers;
        $this->tagline = $tagline;
    }
}
