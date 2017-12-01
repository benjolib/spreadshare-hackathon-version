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
     * @param Message $message
     *
     * @todo remove this and use the php api
     *
     * @return int
     */
    public function sendViaGuzzle(Message $message)
    {
        if (count($message->getFrom()) && $message->getTo())
        {
            $from = [];
            foreach ($message->getFrom() as $fromEmail => $fromName)
            {
                $from[] = $fromName . ' <' . $fromEmail . '>';
            }
            $to = [];
            foreach ($message->getTo() as $fromEmail => $fromName)
            {
                $to[] = $fromName . ' <' . $fromEmail . '>';
            }
            
            $guzzle   = new Client();
            $response = $guzzle->post(
                'https://api.mailgun.net/v3/spreadshare.co/messages',
                [
                    'auth' => ['api', 'key-611a7bf686cb890b8db38ad9ce1a5bbb'],
                    'form_params' => [
                        'from' => implode(', ', $from),
                        'to' => implode(', ', $to),
                        'subject' => $message->getSubject(),
                        'html' => $message->getContent(),
                    ],
                ]
            );
            
            return $response->getStatusCode();
        }
        
        return 0;
    }
    
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
        return $message->send();
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
