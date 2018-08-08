<?php

use DS\Component\Mailer\dto\StreamEmailDto;
use PHPUnit\Framework\TestCase;

class StreamEmailDtoTest extends TestCase
{
    const BASE_URI = "https://spreadshare.co";

    /**
     * @expectedException InvalidArgumentException
     */
    public function testShouldThrowExceptionIfBaseUriIsNotValid(){
        new StreamEmailDto("invalid url");
    }

    public function testSetNameShouldAddStreamName()
    {
        $streamDto = new StreamEmailDto(self::BASE_URI);
        $streamDto->setName("Stream Name");
        $this->assertEquals("Stream Name", $streamDto->getName());
    }

    public function testWitSlugShouldReturnBaseUrlIfSlugIsEmpty()
    {
        $streamDto = new StreamEmailDto(self::BASE_URI);
        $streamDto->withSlug("");
        $this->assertEquals(self::BASE_URI, $streamDto->getLink());
    }

    public function testWitSlugShouldReturnBaseUrlIfSlugIsNull()
    {
        $streamDto = new StreamEmailDto(self::BASE_URI);
        $streamDto->withSlug(null);
        $this->assertEquals(self::BASE_URI, $streamDto->getLink());
    }

    public function testWitSlugShouldReturnValidLink()
    {
        $streamDto = new StreamEmailDto(self::BASE_URI);
        $streamDto->withSlug("explaining-technology-business-politics-and-more");
        $this->assertEquals("https://spreadshare.co/stream/explaining-technology-business-politics-and-more", $streamDto->getLink());
    }

    public function testShouldEncodeToJson(){
        $streamDto = new StreamEmailDto(self::BASE_URI);
        $streamDto->withSlug("explaining-technology-business-politics-and-more")
            ->setName("Stream Name");
        $this->assertEquals("{\"name\":\"Stream Name\",\"link\":\"https:\/\/spreadshare.co\/stream\/explaining-technology-business-politics-and-more\"}", json_encode($streamDto));
    }
}
