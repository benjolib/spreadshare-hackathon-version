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
        'methods' => ['GET'],
    ],
    [
        'url' => '/signup/follow',
        'paths' => [
            'controller' => 'Signup',
            'action' => 'follow',
        ],
        'methods' => ['GET'],
    ],
    [
        'url' => '/signup/location',
        'paths' => [
            'controller' => 'Signup',
            'action' => 'location',
        ],
        'methods' => ['GET'],
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
        'methods' => ['GET'],
    ],
    [
        'url' => '/settings/{page:[a-zA-Z0-9\-]+}',
        'paths' => [
            'controller' => 'UserSettings',
            'action' => 'settings',
        ],
        'methods' => ['GET'],
    ],
    [
        'url' => '/upvote/{id:[a-zA-Z0-9\-]+}',
        'paths' => [
            'controller' => 'Upvote',
            'action' => 'ajax',
        ],
        'methods' => ['GET'],
    ],
    [
        'url' => '/post/{id:[a-zA-Z0-9\-]+}',
        'paths' => [
            'controller' => 'Post',
            'action' => 'index',
        ],
        'methods' => ['GET'],
    ],
    [
        'url' => '/hunt/post',
        'paths' => [
            'controller' => 'Hunt',
            'action' => 'post',
        ],
        'methods' => ['POST'],
    ],
];