<?php

namespace DS\Component\Mailer;

use DS\Application;
use DS\Component\Mailer\dto\NewSubscriberEmailDto;
use GuzzleHttp\Client;
use Phalcon\Logger;
use Phalcon\Mvc\User\Component;
use DS\Component\Mailer\dto\UserEmailDto;

class SpreadshareEmailService extends Component implements Mailer
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

    public function sendWelcomeEmail(String $email, String $userName)
    {

        $this->sendEmail("welcome", ['email' => $email, 'name' => $userName]);
    }

    public function sendNewFollowerEmail(String $email, UserEmailDto $userMeta)
    {
        $this->sendEmail("new-follower", ['emails' => $email, 'person' => $userMeta]);
    }

    public function sendNewSubscriberEmail(String $email, NewSubscriberEmailDto $dto){
        $this->sendEmail("new-subscriber", ['emails' => $email, 'subscription' => $dto]);
    }


    private function sendEmail($path, $data)
    {
        $res = $this->guzzle->post(
            "$this->serviceUrl/email/$path",
            [
                'headers' => [
                    'x-api-key' => $this->apiKey
                ],
                'json' => $data,
                'http_errors' => false
            ]
        );

        $this->logResponse($path, $data, $res);
    }

    private function logResponse($path, $data, $res){
        $code = $res->getStatusCode();
        $jsonData = json_encode($data);
        $phrase = $res->getReasonPhrase();
        if($code == 200){
            Application::instance()->log("Successfully sent $path email with data: $jsonData, msg: $phrase");
        }else{
            Application::instance()->log("Error while sending $path email with data: $jsonData, code: $code, msg: $phrase", Logger::ERROR);
        }
    }

}