<?php

use DS\Component\Session\Adapter\RedisAdapter;

/**
 * Spreadshare
 *
 * Session Initialization
 *
 * @package DS
 * @version $Version$
 */
return function (\DS\Interfaces\GeneralApplication $application, Phalcon\Di\FactoryDefault $di) {
    // Register 'session'
    $di->setShared(
        'session',
        function () use ($di, $application) {
            $config = $application->getConfig();
            
            // return new \Phalcon\Session\Adapter\Files();
            
            /*
            return new \Phalcon\Session\Adapter\Libmemcached(
                [
                    'servers' => $config['memcache']->toArray(),
                    'client' => [
                        Memcached::OPT_HASH => Memcached::HASH_MD5,
                        Memcached::OPT_PREFIX_KEY => 'session.',
                    ],
                    'uniqueId' => 'spreadshare',
                    //'persistent' => true, // might only work for Phalcon\Session\Adapter\Memcache
                    'lifetime' => 3600,
                    'prefix' => 'session.'
                ]
            );
            */
            
            return new RedisAdapter(
                [
                    'uniqueId' => 'DHSession',
                    'host' => $config['redis']->host,
                    'port' => $config['redis']->port,
                    //'auth' => 'foobared',
                    'persistent' => false,
                    'lifetime' => 86400,
                    'prefix' => 'dh.session.',
                    // 'index' => 1,
                ]
            );
        }
    );
};
