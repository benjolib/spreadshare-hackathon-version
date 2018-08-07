<?php

namespace DS\Component\Mailer\dto;


use InvalidArgumentException;
use JsonSerializable;

class StreamEmailDto extends BaseEmailDto implements JsonSerializable
{

    private $baseUri;
    private $name;
    private $link;

    public function __construct(String $baseUri)
    {
        if(!parent::isValidUrl($baseUri)){
            throw new InvalidArgumentException('Invalid base uri');
        }
        $this->baseUri = $baseUri;
    }

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function withSlug($slug)
    {
        if (parent::isNullOrEmptyString($slug)) {
            $this->link = $this->baseUri;
            return $this;
        }

        $this->link = "$this->baseUri/stream/$slug";
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'link' => $this->link
        ];
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLink()
    {
        return $this->link;
    }

}