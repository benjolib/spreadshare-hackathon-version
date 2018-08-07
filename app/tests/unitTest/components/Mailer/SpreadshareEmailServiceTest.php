<?php

use DS\Component\Mailer\dto\NewSubscriberEmailDto;
use DS\Component\Mailer\dto\StreamEmailDto;
use DS\Component\Mailer\dto\UserEmailDto;
use DS\Component\Mailer\SpreadshareEmailService;
use DS\Tests\helpers\GuzzleRequestTest;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SpreadshareEmailServiceTest extends TestCase
{
    public function testShouldSendWelcomeEmail()
    {
        $welcomeTest = new GuzzleRequestTest($this);
        $client = $welcomeTest->expectResponse(new Response(200, ['status' => 'Success']));

        $emailService = new SpreadshareEmailService($client, "https://emails.spreadshare.co", "api-key");
        $emailService->sendWelcomeEmail("test@email.com", "userName");

        $welcomeTest->assertMethod("POST")
            ->assertUrl("https", "emails.spreadshare.co", "/email/welcome")
            ->assertHeader("Content-Type", "application/json")
            ->assertHeader("x-api-key", "api-key")
            ->assertErrorDisabled()
            ->assertBody("{\"email\":\"test@email.com\",\"name\":\"userName\"}");
    }

    public function testShouldNewFollowerEmail()
    {
        $newFollowerTest = new GuzzleRequestTest($this);
        $client = $newFollowerTest->expectResponse(new Response(200, ['status' => 'Success']));

        $emailService = new SpreadshareEmailService($client, "https://emails.spreadshare.co", "api-key");
        $userMeta = $this->createUserMeta();
        $emailService->sendNewFollowerEmail("test@email.com", $userMeta);

        $newFollowerTest->assertMethod("POST")
            ->assertUrl("https", "emails.spreadshare.co", "/email/new-follower")
            ->assertHeader("Content-Type", "application/json")
            ->assertHeader("x-api-key", "api-key")
            ->assertErrorDisabled()
            ->assertBody("{\"emails\":\"test@email.com\",\"person\":{\"name\":\"userName\",\"fullName\":\"userName\",\"tagline\":\"tagline\",\"imageLink\":\"https:\/\/spreadshare.co\/image\/abc\",\"followLink\":\"https:\/\/spreadshare.co\/profile\/userHandle\"}}");
    }

    public function testShouldNewSubscriberEmail()
    {
        $newSubscriberTest = new GuzzleRequestTest($this);
        $client = $newSubscriberTest->expectResponse(new Response(200, ['status' => 'Success']));

        $emailService = new SpreadshareEmailService($client, "https://emails.spreadshare.co", "api-key");
        $userMeta = $this->createUserMeta();
        $stream = $this->createStream();
        $dto = new NewSubscriberEmailDto($userMeta, $stream);

        $emailService->sendNewSubscriberEmail("test@email.com", $dto);

        $newSubscriberTest->assertMethod("POST")
            ->assertUrl("https", "emails.spreadshare.co", "/email/new-subscriber")
            ->assertHeader("Content-Type", "application/json")
            ->assertHeader("x-api-key", "api-key")
            ->assertErrorDisabled()
            ->assertBody('{"emails":"test@email.com","subscription":{"subscriber":{"name":"userName","fullName":"userName","tagline":"tagline","imageLink":"https:\/\/spreadshare.co\/image\/abc","followLink":"https:\/\/spreadshare.co\/profile\/userHandle"},"stream":{"name":"Stream Name","link":"https:\/\/spreadshare.co\/stream\/explaining-technology-business-politics-and-more"}}}');
    }

    private function createUserMeta(){
        $userMeta = new UserEmailDto("https://spreadshare.co");
        $userMeta->withHandle("userHandle")
            ->setName("userName")
            ->setImageLink("/image/abc")
            ->setTagLine("tagline");
        return $userMeta;
    }

    private function createStream(){
        $streamDto = new StreamEmailDto("https://spreadshare.co");
        $streamDto->withSlug("explaining-technology-business-politics-and-more")
            ->setName("Stream Name");
        return $streamDto;
    }
}
