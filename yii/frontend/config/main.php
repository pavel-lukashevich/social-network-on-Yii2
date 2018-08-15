<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'name' => 'social-3AX-xyz',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'baseUrl' => '',
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'friends/delete-subscribe/follow_id=<follower_id:\d+>' => 'friends/delete-subscribe',
                'friends/add-subscribe/follow_id=<follower_id:\d+>' => 'friends/add-subscribe',
                'friends/all/p-<pageNum:\d+>' => 'friends/all',
                'friends/all' => 'friends/all',

                'friends/common/<type:\w+>/id=<userId:\d+>/p-<pageNum:\d+>' => 'friends/common',
                'friends/common/<type:\w+>/id=<userId:\d+>' => 'friends/common',

                'friends/mutuality/p-<pageNum:\d+>' => 'friends/mutuality',
                'friends/mutuality' => 'friends/mutuality',

                'friends/follower/p-<pageNum:\d+>' => 'friends/follower',
                'friends/follower/id=<userId:\d+>/p-<pageNum:\d+>' => 'friends/follower',
                'friends/follower/id=<userId:\d+>' => 'friends/follower',
                'friends/follower' => 'friends/follower',

                'friends/subscribe/p-<pageNum:\d+>' => 'friends/subscribe',
                'friends/subscribe/id=<userId:\d+>/p-<pageNum:\d+>' => 'friends/subscribe',
                'friends/subscribe/id=<userId:\d+>' => 'friends/subscribe',
                'friends/subscribe' => 'friends/subscribe',

                'profile/edit/id=<userId:\d+>' => 'profile/edit',
                'profile/edit' => 'profile/edit',
                'profile/upload' => 'profile/upload',
                'profile/p-<pageNum:\d+>' => 'profile/index',
                'profile/<userId:\d+>/p-<pageNum:\d+>' => 'profile/index',
                'profile/<userId:\d+>' => 'profile/index',

                'news/edit/n-<postId:\d+>' => 'news/edit',
                'news/show/n-<postId:\d+>' => 'news/show',
                'news/hide/n-<postId:\d+>' => 'news/hide',
                'news/delete/n-<postId:\d+>' => 'news/delete',
                'news/view/post-<postId:\d+>' => 'news/view',
                'news/index/p-<pageNum:\d+>' => 'news/index',
                'news/index' => 'news/index',
                'news/<typeList:friends>/p-<pageNum:\d+>' => 'news/index',
                'news/<typeList:friends>' => 'news/index',
                'news' => 'news/index',
            ],
        ],
        'storage' => [
            'class' => 'frontend\components\Storage',
        ],
    ],
    'params' => $params,
];
