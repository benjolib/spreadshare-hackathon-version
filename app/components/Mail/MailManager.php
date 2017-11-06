<?php
namespace DS\Component\Mail;

use DS\Component\Mail\Providers\Mailgun;
use DS\Component\Mail\SwiftTransport\MailgunTransport;
use Phalcon\Mailer\Manager;
use Phalcon\Mailer\Message;

/**
 * Spreadshare
 *
 * Mailing
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
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
        return $message->send();
    }

    /**
     * Override Transport with Mailgun Transport
     *
     * @return null
     *
     * @see MailgunTransport
     */
    protected function registerSwiftTransport()
    {
        $this->transport = $this->getDI()->get('swiftTransport');
    }
}
