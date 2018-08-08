<?php

use DS\Component\Mailer\dto\UserEmailDto;
use PHPUnit\Framework\TestCase;

class UserEmailDtoTest extends TestCase
{

    const BASE_URI = "https://spreadshare.co";

    /**
     * @expectedException InvalidArgumentException
     */
    public function testShouldThrowExceptionIfBaseUriIsNotValid(){
        new UserEmailDto("invalid url");
    }

    public function testSetNameShouldAddBothNameAndFullName()
    {
        $userMeta = new UserEmailDto(self::BASE_URI);
        $userMeta->setName("Person Name");
        $this->assertEquals($userMeta->getName(), "Person Name");
        $this->assertEquals($userMeta->getFullName(), "Person Name");
    }

    public function testSetTaglineShouldBeDefaultIfTaglineNotSet()
    {
        $userMeta = new UserEmailDto(self::BASE_URI);
        $this->assertEquals(UserEmailDto::DEFAULT_TAGLINE, $userMeta->getTagline());
    }

    public function testSetTaglineShouldBeDefaultIfTaglineIsEmpty()
    {
        $userMeta = new UserEmailDto(self::BASE_URI);
        $userMeta->setTagLine("");
        $this->assertEquals(UserEmailDto::DEFAULT_TAGLINE, $userMeta->getTagline());
    }

    public function testSetTaglineShouldBeDefaultIfTaglineIsNull()
    {
        $userMeta = new UserEmailDto(self::BASE_URI);
        $userMeta->setTagLine(null);
        $this->assertEquals(UserEmailDto::DEFAULT_TAGLINE, $userMeta->getTagline());
    }

    public function testSetTaglineShouldAssignTagline()
    {
        $userMeta = new UserEmailDto(self::BASE_URI);
        $userMeta->setTagLine("some tagline");
        $this->assertEquals("some tagline", $userMeta->getTagline());
    }

    public function testSetImageLinkShouldNotAssignIfImageIsEmpty()
    {
        $userMeta = new UserEmailDto(self::BASE_URI);
        $userMeta->setImageLink("");
        $this->assertNull($userMeta->getImageLink());
    }

    public function testSetImageLinkShouldNotAssignIfImageIsNull()
    {
        $userMeta = new UserEmailDto(self::BASE_URI);
        $userMeta->setImageLink(null);
        $this->assertNull($userMeta->getImageLink());
    }

    public function testSetImageLinkShouldAssignIfValidUrl()
    {
        $userMeta = new UserEmailDto(self::BASE_URI);

        $userMeta->setImageLink("https://google.com");
        $this->assertEquals("https://google.com", $userMeta->getImageLink());

        $userMeta->setImageLink("https://graph.facebook.com/v2.8/10155912358881429/picture?width=150&height=150");
        $this->assertEquals("https://graph.facebook.com/v2.8/10155912358881429/picture?width=150&height=150", $userMeta->getImageLink());

        $userMeta->setImageLink("https://graph.facebook.com/v2.8/10155912358881429/picture?width=150&height=150");
        $this->assertEquals("https://graph.facebook.com/v2.8/10155912358881429/picture?width=150&height=150", $userMeta->getImageLink());
    }

    public function testSetImageLinkShouldAppendToBaseUriIfAValidSubUri()
    {
        $userMeta = new UserEmailDto(self::BASE_URI);

        $userMeta->setImageLink("/image/abc.png");
        $this->assertEquals("https://spreadshare.co/image/abc.png", $userMeta->getImageLink());
    }

    public function testSetImageLinkShouldNotAppendToBaseUriIfNotAValidSubUri()
    {
        $userMeta = new UserEmailDto(self::BASE_URI);

        $userMeta->setImageLink("image/abc.png");
        $this->assertNull($userMeta->getImageLink());
    }

    public function testWithHandleShouldReturnBaseUriAsFollowLinkIfHandleIsEmpty(){
        $userMeta = new UserEmailDto(self::BASE_URI);

        $userMeta->withHandle("");
        $this->assertEquals(self::BASE_URI, $userMeta->getFollowLink());
    }

    public function testWithHandleShouldReturnBaseUriAsFollowLinkIfHandleIsNull(){
        $userMeta = new UserEmailDto(self::BASE_URI);

        $userMeta->withHandle(null);
        $this->assertEquals(self::BASE_URI, $userMeta->getFollowLink());
    }

    public function testWithHandleShouldReturnFollowLinkIfHandleIsAValidString(){
        $userMeta = new UserEmailDto(self::BASE_URI);

        $userMeta->withHandle("userHandle");
        $this->assertEquals("https://spreadshare.co/profile/userHandle", $userMeta->getFollowLink());
    }

    public function testShouldEncodeToJson(){
        $userMeta = new UserEmailDto(self::BASE_URI);
        $userMeta->withHandle("userHandle")
            ->setName("userName")
            ->setImageLink("/image/abc")
            ->setTagLine("tagline");
        $this->assertEquals("{\"name\":\"userName\",\"fullName\":\"userName\",\"tagline\":\"tagline\",\"imageLink\":\"https:\/\/spreadshare.co\/image\/abc\",\"followLink\":\"https:\/\/spreadshare.co\/profile\/userHandle\"}", json_encode($userMeta));
    }

}
