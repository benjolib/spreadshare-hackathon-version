<?php

use DS\Component\Mailer\dto\NewSubscriberEmailDto;
use DS\Component\Mailer\dto\StreamEmailDto;
use DS\Component\Mailer\dto\UserEmailDto;
use PHPUnit\Framework\TestCase;

class NewSubscriberEmailDtoTest extends TestCase
{
    const BASE_URI = "https://spreadshare.co";

    /**
     * @expectedException TypeError
     */
    public function testShouldThrowExceptionIfSubscriberIsNotOfCorrectType(){
        new NewSubscriberEmailDto("invalid subscriber", $this->createStream());
    }

    /**
     * @expectedException TypeError
     */
    public function testShouldThrowExceptionIfStreamIsNotOfCorrectType(){
        new NewSubscriberEmailDto($this->createSubscriber(), "invalid stream");
    }

    public function testShouldSetValues(){
        $subscriber = $this->createSubscriber();
        $stream = $this->createStream();
        $dto = new NewSubscriberEmailDto($subscriber, $stream);
        $this->assertEquals($subscriber, $dto->getSubscriber());
        $this->assertEquals($stream, $dto->getStream());
    }

    public function testShouldEncodeToJson(){
        $dto = new NewSubscriberEmailDto($this->createSubscriber(), $this->createStream());
        $this->assertEquals("{\"subscriber\":{\"name\":\"userName\",\"fullName\":\"userName\",\"tagline\":\"tagline\",\"imageLink\":\"https:\/\/spreadshare.co\/image\/abc\",\"followLink\":\"https:\/\/spreadshare.co\/profile\/userHandle\"},\"stream\":{\"name\":\"Stream Name\",\"link\":\"https:\/\/spreadshare.co\/stream\/explaining-technology-business-politics-and-more\"}}", json_encode($dto));
    }

    private function createSubscriber(){
        $userMeta = new UserEmailDto(self::BASE_URI);
        $userMeta->withHandle("userHandle")
            ->setName("userName")
            ->setImageLink("/image/abc")
            ->setTagLine("tagline");
        return $userMeta;
    }

    private function createStream(){
        $streamDto = new StreamEmailDto(self::BASE_URI);
        $streamDto->withSlug("explaining-technology-business-politics-and-more")
            ->setName("Stream Name");
        return $streamDto;
    }
}
