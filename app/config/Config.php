<?php
/**
 * Spreadshare
 *
 * @copyright 2016 | DS
 *
 * @version   $Version$
 * @package   DS\Config
 */
return [
    'domain' => 'spreadshare.docker',
    'elasticsearch' => [
        'host' => 'localhost',
        'port' => '9200',
    ],
    'read-database' => [
        'adapter' => 'Mysql',
        'host' => 'mysql',
        'port' => '3306',
        'username' => 'root',
        'password' => 'spreadshare',
        'dbname' => 'spreadshare',
        'charset' => 'utf8',
        'profile' => false,
    ],
    'write-database' => [
        'adapter' => 'Mysql',
        'host' => 'mysql',
        'port' => '3306',
        'username' => 'root',
        'password' => 'spreadshare',
        'dbname' => 'spreadshare',
        'charset' => 'utf8',
        'profile' => false,
    ],
    'memcache' => [
        [
            'lifetime' => 3600 * 48,
            'host' => 'memcached',
            'port' => 11211,
            'persistent' => true,
            'weight' => 1,
        ],
    ],
    'redis' => [
        'host' => 'redis',
        'port' => 6379,
    ],
    'crypt' => [
        'key' => 'changeme',
    ],
    'mail' => [
        'driver' => 'mailgun',
        'from' => [
            'email' => 'no-reply@spreadshare.co',
            'name' => 'Spreadshare',
        ],
        'mailgun' => [
            'domain' => 'spreadshare.co',
            'apikey' => 'key-611a7bf686cb890b8db38ad9ce1a5bbb',
            'url' => 'api.mailgun.net/v3/spreadshare.co',
        ],
    ],
    'files' => [
        'service' => 'local',
        'local' => [
            'path' => ROOT_PATH . '/system/uploads/',
        ],
        'aws' => [
            'bucket' => 'bucket-name',
            'credentials' => [
                'key' => 'your-key',
                'secret' => 'your-secret',
            ],
            'region' => 'your-region',
            'version' => 'latest|version',
        ],
    ],
    'dirs' => [
        'DS' => ROOT_PATH . '/app/',
        'DS\Controller' => ROOT_PATH . '/app/controllers/',
        'DS\Model' => ROOT_PATH . '/app/models/',
        'DS\ViewModel' => ROOT_PATH . '/app/viewmodels/',
        'DS\Component' => ROOT_PATH . '/app/components/',
        'DS\Modules' => ROOT_PATH . '/app/modules/',
        'DS\Traits' => ROOT_PATH . '/app/traits/',
        'DS\Interfaces' => ROOT_PATH . '/app/interfaces/',
        'DS\Task' => ROOT_PATH . '/app/tasks/',
        'DS\Cli' => ROOT_PATH . '/app/cli/',
        'DS\Constants' => ROOT_PATH . '/app/constants/',
        'DS\Tests' => ROOT_PATH . '/app/tests/',
    ],
    'mode' => 'development',
    
    'hybridauth' => [
        "debug_mode" => true,
        "debug_file" => ROOT_PATH . "/system/log/hybridauth",
        
        //Location where to redirect users once they authenticate with a provider
        'callback' => 'http://spreadshare.app/login',
        
        //Providers specifics
        'providers' => [
            'Twitter' => [
                'enabled' => true,     //Optional: indicates whether to enable or disable Twitter adapter. Defaults to false
                'keys' => [
                    'id' => '14298964',
                    'key' => '', //Required: your Twitter consumer key
                    'secret' => ''  //Required: your Twitter consumer secret
                ],
            ],
            'Google' => [
                'enabled' => false,
                'keys' => [
                    'id' => '...',
                    'secret' => '...',
                ],
            ],
            'Facebook' => [
                'enabled' => true,
                'keys' => [
                    'id' => '',
                    'secret' => '',
                ],
                "scope" => "email",
            ],
        ],
    ],

];
