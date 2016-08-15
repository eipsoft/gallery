<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'language'=>'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'GuMcza3XVq_FIZEUds0MjhFbj2T9mmBh',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        // 'user' => [
        //     'identityClass' => 'app\models\User',
        //     'enableAutoLogin' => true,
        // ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
                '<_c:[\w\-]+>' => '<_c>/index',
                '<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_c>/<_a>',
            ],
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => true,
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['galleryUser'],
        ],
    ],
    'params' => $params,
    'modules' => [
        'gallery' => [
            'class' => 'app\modules\gallery\Module',
            'userName' => 'username',
            'userClass' => '\dektrium\user\models\User',
            'controllerNamespace' => 'app\modules\gallery\controllers\frontend',
            'viewPath' => '@app/modules/gallery/views/frontend',
        ],
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'modules' => [
                'gallery' => [
                    'class' => 'app\modules\gallery\Module',
                    'controllerNamespace' => 'app\modules\gallery\controllers\backend',
                    'viewPath' => '@app/modules/gallery/views/backend',
                    'userName' => 'username',
                    'userClass' => '\dektrium\user\models\User',
                ],
            ]
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
            'admins' => ['admin'],
            'enableUnconfirmedLogin' => true,
            'enableConfirmation' => false,
            'modelMap' => [
                'User' => '\dektrium\user\models\User',
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
