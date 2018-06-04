<?php

namespace DS\Dto\Feed;


class ListingColumn
{
    public $name;
    public $content;
    public $link;

    public function __construct(string $name, $content, $link)
    {
        $this->name = $name;
        $this->content = $content;
        $this->link = $link;
    }
}