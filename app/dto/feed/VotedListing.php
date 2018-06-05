<?php
namespace DS\Dto\Feed;

class VotedListing extends AbstractListing {

    public function getType(): string
    {
        return 'votedListing';
    }
}