<?php
namespace DS\Dto\Feed;

class CollabListing extends AbstractListing {

    public function getType(): string
    {
        return 'collabListing';
    }
}