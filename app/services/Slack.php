<?php

namespace DS\Services;

/**
 * Class Slack provides Slack services
 * @package DS\Services
 */
class Slack
{
    /**
     * @var array of Maknz\Slack\Client's for each handle
     */
    protected $clients = [];

    /**
     * Prepare Slack channel to send a message into it
     *
     * @param array $config [
     *      'webhook-url' => '_SLACK_WEBHOOK_USERS_',
     *      'username' => 'Spreadshare',
     *      'channel' => '#users',
     *  ],
     * @return \Maknz\Slack\Message
     */
    public function to($config)
    {
        // lazy-load of Slack clients
        $handle = md5(json_encode($config));
        if (!isset($this->clients[$handle])) {
            $this->clients[$handle] = new \Maknz\Slack\Client(
                $config['webhook-url'], [
                    'username' => $config['username'],
                    'channel' => $config['channel'],
                    'link_names' => true,
                ]
            );
        }

        // return Maknz\Slack\Message
        return $this->clients[$handle]->to($config['channel']);
    }
}
