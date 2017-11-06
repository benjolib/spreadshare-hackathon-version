<?php

/**
 * Spreadshare
 *
 * Mailer Initialization
 *
 * @package DS
 * @version $Version$
 */
return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di)
{
    /**
     * Setup Mail Manager
     *
     * @return
     */
    $di->set(
        \DS\Constants\Services::MAILER,
        function () use ($application)
        {
            $config = $application->getConfig()->toArray();

            return new \DS\Component\Mail\MailManager($config['mail']);
        }
    );

    /**
     * Setup Mailgun
     *
     * @return
     */
    $di->set(
        'mailgun',
        function () use ($application)
        {
            $config = $application->getConfig()->toArray();

            return new \DS\Component\Mail\Providers\Mailgun(
                $config['mail']['mailgun']['apikey'],
                null,
                $config['mail']['mailgun']['url']
            );
        }
    );

    /**
     * Setup Mailgun Swift Transport
     *
     * @return
     */
    $di->set(
        'swiftTransport',
        function () use ($application, $di)
        {
            $config = $application->getConfig()->toArray();

            return new \DS\Component\Mail\SwiftTransport\MailgunTransport(
                new \Swift_Events_SimpleEventDispatcher(),
                $di->get('mailgun'),
                $config['mail']['mailgun']['domain']
            );
        }
    );

};