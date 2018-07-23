<?php

namespace DS\Services;


use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

const apikey = "qQiVtMRsKH9sGvsy1X9q53aZDpHHt8Qb1jfS1SP7";

class Email
{
    public function newStream()
    {

    }

    private function send($url, $to, $emailData )
    {
        $client = new Client([
            'base_uri' => 'https://6qr9ti9ct5.execute-api.eu-central-1.amazonaws.com/stage',
            'timeout' => 5.0,
        ]);
        $headers = [
            'x-api-key' => apikey,
        ];

        $response = $client->post($url, [
                RequestOptions::JSON => ['foo' => 'bar'],
        ]);
    }
}