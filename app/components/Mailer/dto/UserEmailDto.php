<?php

namespace DS\Component\Mailer\dto;

use InvalidArgumentException;
use JsonSerializable;

class UserEmailDto extends BaseEmailDto implements JsonSerializable
{
    const DEFAULT_TAGLINE = 'A Spreadshare member';
    private $name;
    private $fullName;
    private $tagline = self::DEFAULT_TAGLINE;
    private $imageLink;
    private $followLink;
    private $baseUri;

    public function __construct(String $baseUri)
    {
        if(!parent::isValidUrl($baseUri)){
            throw new InvalidArgumentException('Invalid base uri');
        }
        $this->baseUri = $baseUri;
    }

    public function setName(String $name)
    {
        $this->name = $name;
        $this->fullName = $name;
        return $this;
    }

    public function setTagLine($tagline)
    {
        if (parent::isNullOrEmptyString($tagline)) {
            return $this;
        }

        $this->tagline = $tagline;
        return $this;
    }

    public function setImageLink($imageLink)
    {
        if (parent::isValidUrl($imageLink)) {
            $this->imageLink = $imageLink;
        } else if (!parent::isNullOrEmptyString($imageLink) && $this->isValidSubUrl($imageLink)) {
            $this->imageLink = "$this->baseUri$imageLink";
        }
        return $this;
    }

    public function withHandle($handle)
    {
        if (parent::isNullOrEmptyString($handle)) {
            $this->followLink = $this->baseUri;
            return $this;
        }

        $this->followLink = "$this->baseUri/profile/$handle";
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'fullName' => $this->fullName,
            'tagline' => $this->tagline,
            'imageLink' => $this->imageLink,
            'followLink' => $this->followLink
        ];
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function getTagline(): string
    {
        return $this->tagline;
    }

    public function getImageLink()
    {
        return $this->imageLink;
    }

    public function getFollowLink()
    {
        return $this->followLink;
    }

    public function isValid()
    {
        return true;
    }
}