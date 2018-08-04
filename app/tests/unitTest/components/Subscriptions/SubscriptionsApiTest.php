<?php

namespace DS\Component\Subscriptions;


use DS\Tests\helpers\GuzzleRequestTest;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SubscriptionsApiTest extends TestCase
{
    public function testShouldSendSubscriptionCall()
    {
        $subscribeTest = new GuzzleRequestTest($this);
        $client = $subscribeTest->expectResponse(new Response(200, ['status' => 'Success']));

        $subService = new SubscriptionsApi($client, "https://subscriptions.spreadshare.co", "api-key");
        $subService->subscribeForEmailNotifications(123, 456, "test@email.com", "daily");

        $subscribeTest->assertMethod("POST")
            ->assertUrl("https", "subscriptions.spreadshare.co", "/123/subscriptions/456")
            ->assertHeader("Content-Type", "application/json")
            ->assertHeader("x-api-key", "api-key")
            ->assertErrorDisabled()
            ->assertBody("{\"channel\":\"email\",\"frequency\":\"daily\",\"email\":\"test@email.com\"}");
    }

    public function testShouldSendUnsubscriptionCall()
    {
        $subscribeTest = new GuzzleRequestTest($this);
        $client = $subscribeTest->expectResponse(new Response(200, ['status' => 'Success']));

        $subService = new SubscriptionsApi($client, "https://subscriptions.spreadshare.co", "api-key");
        $subService->unsubscribeFromEmailNotifications(123, 456);

        $subscribeTest->assertMethod("DELETE")
            ->assertUrl("https", "subscriptions.spreadshare.co", "/123/subscriptions/456/email")
            ->assertHeader("x-api-key", "api-key")
            ->assertErrorDisabled();
    }
}
