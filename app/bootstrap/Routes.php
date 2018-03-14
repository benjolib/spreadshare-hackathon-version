<?php
/**
 * Define all non-dynamic routes here.
 */
return [
    [
        'url' => '/login/twitter',
        'paths' => [
            'controller' => 'Login',
            'action' => 'loginWithTwitter',
        ],
        'methods' => ['GET'],
    ],
    [
        'url' => '/login/facebook',
        'paths' => [
            'controller' => 'Login',
            'action' => 'loginWithFacebook',
        ],
        'methods' => ['GET'],
    ],
    [
        'url' => '/login/google',
        'paths' => [
            'controller' => 'Login',
            'action' => 'loginWithGoogle',
        ],
        'methods' => ['GET'],
    ],
    [
        'url' => '/signup',
        'paths' => [
            'controller' => 'Signup',
            'action' => 'index',
        ],
        'methods' => ['GET'],
    ],
    [
        'url' => '/signup/topics',
        'paths' => [
            'controller' => 'Signup',
            'action' => 'topics',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/signup/follow',
        'paths' => [
            'controller' => 'Signup',
            'action' => 'follow',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/signup/location',
        'paths' => [
            'controller' => 'Signup',
            'action' => 'location',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/user/{user:[a-zA-Z0-9\-]+}',
        'paths' => [
            'controller' => 'User',
            'action' => 'profile',
        ],
        'methods' => ['GET'],
    ],
    [
        'url' => '/user/{user:[a-zA-Z0-9\-]+}/{page:[a-z]+}',
        'paths' => [
            'controller' => 'User',
            'action' => 'profile',
        ],
        'methods' => ['GET'],
    ],
    [
        'url' => '/feed/{type:[a-zA-Z0-9\-]+}',
        'paths' => [
            'controller' => 'Feed',
            'action' => 'index',
        ],
        'methods' => ['GET'],
    ],
    [
        'url' => '/leaderboard/{tab:[a-zA-Z0-9\-]+}',
        'paths' => [
            'controller' => 'Leaderboard',
            'action' => 'index',
        ],
        'methods' => ['GET'],
    ],
    [
        'url' => '/settings',
        'paths' => [
            'controller' => 'User_Settings',
            'action' => 'settings',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/settings/{page:[a-zA-Z0-9\-]+}',
        'paths' => [
            'controller' => 'User_Settings', // @see https://docs.phalconphp.com/en/latest/routing -> camelized
            'action' => 'settings',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/upvote/{id:[a-zA-Z0-9\-]+}',
        'paths' => [
            'controller' => 'Upvote',
            'action' => 'ajax',
        ],
        'methods' => ['POST'],
    ],
    [
        'url' => '/tables/{order:[a-z0-9\-]+}',
        'paths' => [
            'controller' => 'Tables',
            'action' => 'index',
        ],
        'methods' => ['GET'],
    ],
    [
        'url' => '/tables/{order:[a-z0-9\-]+}/{date:[a-z0-9\-]+}',
        'paths' => [
            'controller' => 'Tables',
            'action' => 'index',
        ],
        'methods' => ['GET'],
    ],
    [
        'url' => '/table/{id:[0-9]+}',
        'paths' => [
            'controller' => 'Table_Detail',
            'action' => 'index',
        ],
        'methods' => ['GET'],
    ],
    [
        'url' => '/download/table/{id:[0-9]+}/{format:[a-z]+}',
        'paths' => [
            'controller' => 'Table_Download',
            'action' => 'index',
        ],
        'methods' => ['GET'],
    ],
    [
        'url' => '/table/{id:[0-9]+}/{tab:[a-z]+}',
        'paths' => [
            'controller' => 'Table_Detail',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/table/{id:[0-9]+}/{tab:[a-z]+}/{param:[a-z]+}',
        'paths' => [
            'controller' => 'Table_Detail',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/table/add',
        'paths' => [
            'controller' => 'Add_Table',
            'action' => 'add',
        ],
        'methods' => ['GET'],
    ],
    [
        'url' => '/table/add/description/{selection:[a-z\-]+}',
        'paths' => [
            'controller' => 'Add_Table',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/table/add/choose/{selection:[a-z\-]+}',
        'paths' => [
            'controller' => 'Add_Table',
            'action' => 'choose',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/table/add/confirm',
        'paths' => [
            'controller' => 'Add_Table',
            'action' => 'confirm',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/table/{id:[0-9]+}/delete',
        'paths' => [
            'controller' => 'Table',
            'action' => 'delete',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/requests',
        'paths' => [
            'controller' => 'Change_Request',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
];
