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
        'url' => '/settings',
        'paths' => [
            'controller' => 'UserSettings',
            'action' => 'settings',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/settings/{page:[a-zA-Z0-9\-]+}',
        'paths' => [
            'controller' => 'UserSettings',
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
        'url' => '/tables/{order:[a-zA-Z0-9\-]+}',
        'paths' => [
            'controller' => 'Index',
            'action' => 'index',
        ],
        'methods' => ['GET'],
    ],
];