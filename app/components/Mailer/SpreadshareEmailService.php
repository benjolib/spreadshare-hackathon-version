<?php

namespace DS\Component\Mailer;

use DS\Application;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Phalcon\Http\ResponseInterface;
use Phalcon\Logger;
use Phalcon\Mvc\User\Component;

class SpreadshareEmailService extends Component implements Mailer
{
    private $serviceUrl;
    private $apiKey;

    public function sendWelcomeEmail(String $email, String $userName)
    {
        $this->sendEmail("welcome", ['email' => $email, 'name' => $userName]);
    }

    public function __construct(String $serviceUrl, String $apiKey)
    {
        $this->serviceUrl = $serviceUrl;
        $this->apiKey = $apiKey;
    }

    private function sendEmail($path, $data)
    {
        $guzzle = new Client();
        $res = $guzzle->post(
            "$this->serviceUrl/email/$path",
            [
                'headers' => [
                    'x-api-key' => $this->apiKey
                ],
                'json' => $data,
                'http_errors' => false
            ]
        );

        $code = $res->getStatusCode();
        if($code == 200){
            $email = $data["email"];
            Application::instance()->log("Successfully sent $path email for $email");
        }else{
            $email = $data["email"];
            $phrase = $res->getReasonPhrase();
            Application::instance()->log("Error while sending $path email for $email: $code, $phrase", Logger::ERROR);
        }
    }

}