<?php
/**
 * Created by PhpStorm.
 * User: antonienko
 * Date: 31/05/18
 * Time: 11:10
 */
namespace DS\Dto\Feed;

class FeedElementCollection
{
    /** @var FeedDto[] */
    public $elements;

    public function add(FeedDto $element)
    {
        $this->elements[] = $element;
    }
}