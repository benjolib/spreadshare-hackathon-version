<?php

namespace DS\Listeners;

use DS\Application;
use GuzzleHttp\Client;
use DS\Model\Wallet;
use Bernard\Message\PlainMessage;
use DS\Component\ServiceManager;


class Wallet
{


    public function newWallet(PlainMessage $message)
    {

      try {

        // Create a data
        $data = [
          'userId' => $message->get('userId'),
          'email' => $message->get('email')
        ];

        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);

        $response = $client->post('http://ec2-18-217-109-204.us-east-2.compute.amazonaws.com/address',
            ['body' => json_encode($data)]
        );


        $object = json_decode($response->getBody()->getContents());

        Wallet::findByFieldValue($data['userId'], 'userId')->setUserId($data['userId'])->setContractAddress($object->address)->save();



      } catch (Exception $e) {

        Application::instance()->log($e->getMessage(), Logger::CRITICAL);

      }

    }


}
