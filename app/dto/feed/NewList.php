<?php
namespace DS\Dto\Feed;

class NewList extends AbstractList {
    public function getType(): string
    {
        return 'newList';
    }
}