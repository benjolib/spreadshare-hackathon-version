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
    public $elements = [];

    public function add(FeedDto $element)
    {
        $this->elements[] = $element;
    }

    public function getIds():array
    {
        $result = [];
        foreach ($this->elements as $element) {
            if (!empty($element->getId())) {
                $result[] = $element->getId();
            }
        }
        return $result;
    }
}