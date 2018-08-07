<?php

use DS\Component\Subscriptions\dto\SubscribeDto;
use DS\Component\Subscriptions\dto\SubscriptionChannel;
use DS\Component\Subscriptions\dto\SubscriptionFrequency;
use PHPUnit\Framework\TestCase;

class SubscribeDtoTest extends TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testShouldThrowExceptionIfChannelIsNotValid(){
        new SubscribeDto("invalid channel",
            SubscriptionFrequency::DAILY,
            "test@email.com");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testShouldThrowExceptionIfFrequencyIsNotValid(){
        new SubscribeDto(SubscriptionChannel::EMAIL,
            "invalid frequency",
            "test@email.com");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testShouldThrowExceptionIfEmailIsNotValid(){
        new SubscribeDto(SubscriptionChannel::EMAIL,
            SubscriptionFrequency::DAILY,
            "invalid email");
    }

    public function testShouldEncodeToJson(){
        $dto = new SubscribeDto(SubscriptionChannel::EMAIL,
            SubscriptionFrequency::DAILY,
            "test@email.com");
        $this->assertEquals("{\"channel\":\"email\",\"frequency\":\"daily\",\"email\":\"test@email.com\"}", json_encode($dto));
    }
}
