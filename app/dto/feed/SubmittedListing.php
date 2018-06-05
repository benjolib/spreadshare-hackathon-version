<?php
namespace DS\Dto\Feed;

class SubmittedListing extends AbstractListing {

    public function getType(): string
    {
        return 'submittedListing';
    }
}