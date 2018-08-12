<?php

namespace DS\Component\Subscriptions;

use DS\Application;
use DS\Component\Subscriptions\dto\SubscribeDto;
use DS\Component\Subscriptions\dto\SubscriptionChannel;
use GuzzleHttp\Client;
use Phalcon\Logger;

class SubscriptionsApi implements SubscriptionsService
{
    private $serviceUrl;
    private $apiKey;
    private $guzzle;

    public function __construct(Client $client, String $serviceUrl, String $apiKey)
    {
        $this->guzzle = $client;
        $this->serviceUrl = $serviceUrl;
        $this->apiKey = $apiKey;
    }

    public function subscribeForEmailNotifications(int $userId, int $tableId, String $email, String $frequency)
    {
        $path = "$userId/subscriptions/$tableId";
        $dto = new SubscribeDto(SubscriptionChannel::EMAIL, $frequency, $email);
        $this->postReq($path, $dto);
    }

    public function unsubscribeFromEmailNotifications(int $userId, int $tableId)
    {
        $path = "$userId/subscriptions/$tableId/email";
        $this->deleteReq($path);
    }

    private function postReq($path, $data)
    {
        $res = $this->guzzle->post(
            "$this->serviceUrl/$path",
            [
                'headers' => [
                    'x-api-key' => $this->apiKey
                ],
                'json' => $data,
                'http_errors' => false
            ]
        );

        $code = $res->getStatusCode();
        $jsonData = json_encode($data);
        $phrase = $res->getReasonPhrase();
        if ($code == 200) {
            Application::instance()->log("Successfully called $path with data: $jsonData, msg: $phrase");
        } else {
            Application::instance()->log("Error while calling $path with data: $jsonData, code: $code, msg: $phrase", Logger::ERROR);
        }
    }

    private function deleteReq($path)
    {
        $res = $this->guzzle->delete(
            "$this->serviceUrl/$path",
            [
                'headers' => [
                    'x-api-key' => $this->apiKey
                ],
                'http_errors' => false
            ]
        );

        $code = $res->getStatusCode();
        $phrase = $res->getReasonPhrase();
        if ($code == 200) {
            Application::instance()->log("Successfully called delete at $path, msg: $phrase");
        } else {
            Application::instance()->log("Error while calling delete at $path, msg: $phrase", Logger::ERROR);
        }
    }
}