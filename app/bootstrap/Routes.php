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
        'url' => '/user/{user:[a-zA-Z0-9\-]+}',
        'paths' => [
            'controller' => 'User',
            'action' => 'profile',
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