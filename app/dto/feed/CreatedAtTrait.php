<?php
namespace DS\Dto\Feed;

use DateTimeImmutable;

trait CreatedAtTrait
{
    /** @var DateTimeImmutable */
    protected $createdAt;
    protected $id;
    
    public function getCreatedAt():DateTimeImmutable
    {
        return $this->createdAt;    
    }

    public function getId():int
    {
        return $this->id;
    }
}