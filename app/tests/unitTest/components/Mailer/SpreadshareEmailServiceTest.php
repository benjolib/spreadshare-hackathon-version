<?php

use DS\Component\Mailer\dto\UserMetaEmailDto;
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
        $welcomeTest = new GuzzleRequestTest($this);
        $client = $welcomeTest->expectResponse(new Response(200, ['status' => 'Success']));

        $emailService = new SpreadshareEmailService($client, "https://emails.spreadshare.co", "api-key");
        $userMeta = new UserMetaEmailDto("https:spreadshare.co");
        $userMeta->withHandle("userHandle")
            ->setName("userName")
            ->setImageLink("/image/abc")
            ->setTagLine("tagline");
        $emailService->sendNewFollowerEmail("test@email.com", $userMeta);

        $welcomeTest->assertMethod("POST")
            ->assertUrl("https", "emails.spreadshare.co", "/email/new-follower")
            ->assertHeader("Content-Type", "application/json")
            ->assertHeader("x-api-key", "api-key")
            ->assertErrorDisabled()
            ->assertBody("{\"email\":\"test@email.com\",\"person\":{\"name\":\"userName\",\"fullName\":\"userName\",\"tagline\":\"tagline\",\"imageLink\":\"https:spreadshare.co\/image\/abc\",\"followLink\":\"https:spreadshare.co\/profile\/userHandle\"}}");
    }
}
