<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 30/05/18
 * Time: 19:04
 */

namespace DS\Dto\Feed;

interface FeedDto
{
    public function getCreatedAt():\DateTimeImmutable;
    public function getType():string;
    public function getId():string;
}