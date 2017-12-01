<?php

namespace DS\Component\Mail;

use DS\Component\Mail\Providers\Mailgun;
use DS\Component\Mail\SwiftTransport\MailgunTransport;
use GuzzleHttp\Client;
use Phalcon\Mailer\Manager;
use Phalcon\Mailer\Message;

/**
 * Spreadshare
 *
 * Mailing
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component\Mail
 */
class MailManager extends Manager
{
    /**
     * @var Mailgun
     */
    protected $mailgun;
    
    /**
     * Returns amount of mails that have been sent. Returns 0 if there is an error.
     *
     * Does not throw any Exceptions!!
     *
     * @param Message $message
     *
     * @return int
     */
    public function send(Message $message)
    {
        $guzzle = new Client();
        $response = $guzzle->get(
            'https://api.mailgun.net/v3/spreadshare.co/messages',
            [
                'auth' => ['api:key-611a7bf686cb890b8db38ad9ce1a5bbb', ''],
                'form_params' => [
                    'from' => $message->getFrom(),
                    'to' => $message->getTo(),
                    'subject' => $message->getSubject(),
                    'text' => $message->getContent(),
                ],
            ]
        );
        return $response->getStatusCode();
        
        //return $message->send();
    }
    
    /**
     * Override Transport with Mailgun Transport
     *
     * @see MailgunTransport
     */
    protected function registerSwiftTransport()
    {
        $this->transport = $this->getDI()->get('swiftTransport');
    }
}
