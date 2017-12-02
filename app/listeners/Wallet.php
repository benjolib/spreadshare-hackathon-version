<?php

namespace DS\Listeners;

use DS\Application;
use GuzzleHttp\Client;
use DS\Model\Wallet as WalletModel;
use Bernard\Message\PlainMessage;
use DS\Component\ServiceManager;


class Wallet
{


    public function newWallet(PlainMessage $message)
    {

      try {

        // getClient
        $client = ServiceManager::instance()->getDI()->get('wallet');

        // Create a data
        $data = [
          'userId' => $message->get('userId'),
          'email' => $message->get('email')
        ];

        /**
         * Post to create a new wallet
         */
        $response = $client->post('/address',['body' => json_encode($data)] );

        $responseObject = json_decode($response->getBody()->getContents());

        WalletModel::findByFieldValue('userId', $data['userId'])->setContractAddress($responseObject->address)->save();


      } catch (Exception $e) {

        Application::instance()->log($e->getMessage(), Logger::CRITICAL);

      }

    }


}
