<?php

return [
    'name' => 'WEB',
    'language' => 'ru-RU',
    'sourceLanguage' => 'ru-RU',
    'timeZone' => 'Europe/Kiev',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => ['eventManager', 'attachment'],
    'modules' => [
        'user' => [
            'class' => 'chipmob\user\Module',
            'adminPermission' => 'RootPermission',
            'modelMap' => [
                'User' => 'common\models\User',
            ],
        ],
        'attachment' => [
            'class' => 'chipmob\attachment\Module',
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'yii\caching\ArrayCache',
        ],
        'eventManager' => [
            'class' => 'common\components\EventManager',
            'events' => require __DIR__ . '/events.php',
        ],
        'i18n' => [
            'translations' => [
                'common*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'ru-RU',
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'file' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logVars' => [],
                ],
            ],
        ],
    ],
    'container' => [
        'definitions' => [
            'yii\redis\Session' => ['class' => 'common\components\redis\Session', 'userKeySeparator' => 'u:', 'sessionKeySeparator' => 's:'],
        ],
    ],
];
