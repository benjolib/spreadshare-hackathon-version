<?php

namespace DS\Component\Subscriptions\dto;

use InvalidArgumentException;
use JsonSerializable;

class SubscribeDto implements JsonSerializable
{
    private $channel;
    private $frequency;
    private $email;

    public function __construct(String $channel,
                                String $frequency,
                                String $email)
    {
        if (!SubscriptionChannel::isValidValue($channel)
            || !SubscriptionFrequency::isValidValue($frequency)
            || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new InvalidArgumentException("Invalid params");
    }


        $this->channel = $channel;
        $this->frequency = $frequency;
        $this->email = $email;
    }

    public function jsonSerialize()
    {
        return [
            "channel" => $this->channel,
            "frequency" => $this->frequency,
            "email" => $this->email,
        ];
    }


}