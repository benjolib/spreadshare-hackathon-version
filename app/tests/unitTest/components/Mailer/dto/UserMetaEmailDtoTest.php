<?php

use DS\Component\Mailer\dto\UserMetaEmailDto;
use PHPUnit\Framework\TestCase;

class UserMetaEmailDtoTest extends TestCase
{

    const BASE_URI = "https://spreadshare.co";
    public function testSetNameShouldAddBothNameAndFullName()
    {
        $userMeta = new UserMetaEmailDto(self::BASE_URI);
        $userMeta->setName("Person Name");
        $this->assertEquals($userMeta->getName(), "Person Name");
        $this->assertEquals($userMeta->getFullName(), "Person Name");
    }

    public function testSetTaglineShouldBeDefaultIfTaglineNotSet()
    {
        $userMeta = new UserMetaEmailDto(self::BASE_URI);
        $this->assertEquals($userMeta->getTagline(), UserMetaEmailDto::DEFAULT_TAGLINE);
    }

    public function testSetTaglineShouldBeDefaultIfTaglineIsEmpty()
    {
        $userMeta = new UserMetaEmailDto(self::BASE_URI);
        $userMeta->setTagLine("");
        $this->assertEquals($userMeta->getTagline(), UserMetaEmailDto::DEFAULT_TAGLINE);
    }

    public function testSetTaglineShouldBeDefaultIfTaglineIsNull()
    {
        $userMeta = new UserMetaEmailDto(self::BASE_URI);
        $userMeta->setTagLine(null);
        $this->assertEquals($userMeta->getTagline(), UserMetaEmailDto::DEFAULT_TAGLINE);
    }

    public function testSetTaglineShouldAssignTagline()
    {
        $userMeta = new UserMetaEmailDto(self::BASE_URI);
        $userMeta->setTagLine("some tagline");
        $this->assertEquals($userMeta->getTagline(), "some tagline");
    }

    public function testSetImageLinkShouldNotAssignIfImageIsEmpty()
    {
        $userMeta = new UserMetaEmailDto(self::BASE_URI);
        $userMeta->setImageLink("");
        $this->assertEquals($userMeta->getImageLink(), null);
    }

    public function testSetImageLinkShouldNotAssignIfImageIsNull()
    {
        $userMeta = new UserMetaEmailDto(self::BASE_URI);
        $userMeta->setImageLink(null);
        $this->assertEquals($userMeta->getImageLink(), null);
    }

    public function testSetImageLinkShouldAssignIfValidUrl()
    {
        $userMeta = new UserMetaEmailDto(self::BASE_URI);

        $userMeta->setImageLink("https://google.com");
        $this->assertEquals($userMeta->getImageLink(), "https://google.com");

        $userMeta->setImageLink("https://graph.facebook.com/v2.8/10155912358881429/picture?width=150&height=150");
        $this->assertEquals($userMeta->getImageLink(), "https://graph.facebook.com/v2.8/10155912358881429/picture?width=150&height=150");

        $userMeta->setImageLink("https://graph.facebook.com/v2.8/10155912358881429/picture?width=150&height=150");
        $this->assertEquals($userMeta->getImageLink(), "https://graph.facebook.com/v2.8/10155912358881429/picture?width=150&height=150");
    }

    public function testSetImageLinkShouldAppendToBaseUriIfAValidSubUri()
    {
        $userMeta = new UserMetaEmailDto(self::BASE_URI);

        $userMeta->setImageLink("/image/abc.png");
        $this->assertEquals($userMeta->getImageLink(), "https://spreadshare.co/image/abc.png");
    }

    public function testSetImageLinkShouldNotAppendToBaseUriIfNotAValidSubUri()
    {
        $userMeta = new UserMetaEmailDto(self::BASE_URI);

        $userMeta->setImageLink("image/abc.png");
        $this->assertEquals($userMeta->getImageLink(), null);
    }

    public function testWithHandleShouldReturnBaseUriAsFollowLinkIfHandleIsEmpty(){
        $userMeta = new UserMetaEmailDto(self::BASE_URI);

        $userMeta->withHandle("");
        $this->assertEquals($userMeta->getFollowLink(), self::BASE_URI);
    }

    public function testWithHandleShouldReturnBaseUriAsFollowLinkIfHandleIsNull(){
        $userMeta = new UserMetaEmailDto(self::BASE_URI);

        $userMeta->withHandle(null);
        $this->assertEquals($userMeta->getFollowLink(), self::BASE_URI);
    }

    public function testWithHandleShouldReturnFollowLinkIfHandleIsAValidString(){
        $userMeta = new UserMetaEmailDto(self::BASE_URI);

        $userMeta->withHandle("userHandle");
        $this->assertEquals($userMeta->getFollowLink(), "https://spreadshare.co/profile/userHandle");
    }

    public function testShouldEncodeToJson(){
        $userMeta = new UserMetaEmailDto(self::BASE_URI);
        $userMeta->withHandle("userHandle")
            ->setName("userName")
            ->setImageLink("/image/abc")
            ->setTagLine("tagline");
        $this->assertEquals(json_encode($userMeta), "{\"name\":\"userName\",\"fullName\":\"userName\",\"tagline\":\"tagline\",\"imageLink\":\"https:\/\/spreadshare.co\/image\/abc\",\"followLink\":\"https:\/\/spreadshare.co\/profile\/userHandle\"}");
    }

}
