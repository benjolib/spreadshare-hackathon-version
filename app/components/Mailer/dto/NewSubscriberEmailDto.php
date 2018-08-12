<?php


namespace DS\Component\Mailer\dto;


use JsonSerializable;

class NewSubscriberEmailDto extends BaseEmailDto implements JsonSerializable
{
    private $subscriber;
    private $stream;

    public function __construct(UserEmailDto $subscriber, StreamEmailDto $stream)
    {
        $this->subscriber = $subscriber;
        $this->stream = $stream;
    }

    public function jsonSerialize()
    {
        return [
            'subscriber' => $this->subscriber,
            'stream' => $this->stream
        ];
    }

    public function getSubscriber()
    {
        return $this->subscriber;
    }

    public function getStream()
    {
        return $this->stream;
    }

}