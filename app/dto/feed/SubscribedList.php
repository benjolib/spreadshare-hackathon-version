<?php
namespace DS\Dto\Feed;

class SubscribedList extends AbstractList {
    public function getType(): string
    {
        return 'subscribedList';
    }
}