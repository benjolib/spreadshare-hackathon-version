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
        'url' => '/profile/{user:[a-zA-Z0-9\-]+}/{page:[a-z]+}',
        'paths' => [
            'controller' => 'User',
            'action' => 'profile',
        ],
        'methods' => ['GET'],
    ],
    [
        'url' => '/profile/{user:[a-zA-Z0-9\-]+}',
        'paths' => [
            'controller' => 'User',
            'action' => 'profile',
        ],
        'methods' => ['GET'],
    ],
    [
        'url' => '/user/follow/{user:[a-zA-Z0-9\-]+}',
        'paths' => [
            'controller' => 'User_Follow',
            'action' => 'follow',
        ],
        'methods' => ['GET'],
    ],
    //TODO This one looks like can be removed
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
        'url' => '/oldsettings',
        'paths' => [
            'controller' => 'User_Settings',
            'action' => 'settings',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/oldsettings/{page:[a-zA-Z0-9\-]+}',
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
        'url' => '/table/{id:[0-9]+}',
        'paths' => [
            'controller' => 'Table_Detail',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
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
        'url' => '/stream/{id:[0-9]+}/delete',
        'paths' => [
            'controller' => 'Table',
            'action' => 'delete',
        ],
        'methods' => ['GET', 'POST'],
    ],

    // NEW ROUTES

    // pages

    [
        'url' => '/explore/{selection:[a-z0-9\-]+}',
        'paths' => [
            'controller' => 'Explore',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/explore/{selection:[a-z0-9\-]+}/{secondSelection:[a-z0-9\-]+}',
        'paths' => [
            'controller' => 'Explore',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/stream/{slug}',
        'paths' => [
            'controller' => 'List',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/stream/{id}/edit',
        'paths' => [
            'controller' => 'List',
            'action' => 'edit',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/submissions',
        'paths' => [
            'controller' => 'Submission',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/collaborations',
        'paths' => [
            'controller' => 'Collaboration',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/streams',
        'paths' => [
            'controller' => 'Lists',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/search',
        'paths' => [
            'controller' => 'Search',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/karma',
        'paths' => [
            'controller' => 'Karma',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/settings',
        'paths' => [
            'controller' => 'Settings',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/for\-you',
        'paths' => [
            'controller' => 'Kaka',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/sign-up',
        'paths' => [
            'controller' => 'TempSignUp',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/sign-in',
        'paths' => [
            'controller' => 'TempSignIn',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/activity',
        'paths' => [
            'controller' => 'Activity',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/subscriptions',
        'paths' => [
            'controller' => 'Subscriptions',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/create\-list',
        'paths' => [
            'controller' => 'CreateList',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/history',
        'paths' => [
            'controller' => 'History',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/about',
        'paths' => [
            'controller' => 'About',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/admin',
        'paths' => [
            'controller' => 'Admin',
            'action' => 'index',
        ],
        'methods' => ['GET', 'POST'],
    ],

    // api

    [
        'url' => '/row/{id:[0-9]+}/add',
        'paths' => [
            'controller' => 'Request_Add',
            'action' => 'add',
        ],
        'methods' => ['POST'],
    ],
    [
        'url' => '/row/{id:[0-9]+}/delete',
        'paths' => [
            'controller' => 'Request_Delete',
            'action' => 'delete',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/submissions/add/revoke/{id:[0-9]+}',
        'paths' => [
            'controller' => 'Request_Add',
            'action' => 'revoke',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/collaborations/add/approve/{id:[0-9]+}',
        'paths' => [
            'controller' => 'Request_Add',
            'action' => 'approve',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/collaborations/add/deny/{id:[0-9]+}',
        'paths' => [
            'controller' => 'Request_Add',
            'action' => 'deny',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/collaborations/delete/approve/{id:[0-9]+}',
        'paths' => [
            'controller' => 'Request_Delete',
            'action' => 'approve',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/collaborations/delete/deny/{id:[0-9]+}',
        'paths' => [
            'controller' => 'Request_Delete',
            'action' => 'deny',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/submissions/delete/revoke/{id:[0-9]+}',
        'paths' => [
            'controller' => 'Request_Delete',
            'action' => 'revoke',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/stream/subscribe/{tableId:[0-9]+}',
        'paths' => [
            'controller' => 'List_Subscription',
            'action' => 'subscribe',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/stream/comment/{tableId:[0-9]+}',
        'paths' => [
            'controller' => 'List_Subscription',
            'action' => 'subscribe',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/stream/flag/{tableId:[0-9]+}/{reason}',
        'paths' => [
            'controller' => 'List_Flag',
            'action' => 'flag',
        ],
        'methods' => ['GET', 'POST'],
    ],
    [
        'url' => '/tag/{tagId:[0-9]+}',
        'paths' => [
            'controller' => 'Index',
            'action' => 'index',
        ]
    ]
];
