<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
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
                'friends/mutuality' => 'friends/mutuality',
                'friends/follower/<userId:\w+>' => 'friends/follower',
                'friends/follower' => 'friends/follower',
                'friends/add-subscribe/follow_id=<follower_id:\d+>' => 'friends/add-subscribe',
                'friends/all/p-<pageNum:\d+>' => 'friends/all',
                'friends/all' => 'friends/all',
                'friends/<userId:\w+>' => 'friends/index',
                'friends' => 'friends/index',
//                'friends\w+' => 'friends/index',

                'profile/edit\w+' => 'profile/index',
                'profile/edit' => 'profile/edit',
                'profile/upload' => 'profile/upload',
                'profile/<username:\w+>' => 'profile/index',
                'profile\w+' => 'profile/index',
            ],
        ],
        'storage' => [
            'class' => 'frontend\components\Storage',
        ],
    ],
    'params' => $params,
];
