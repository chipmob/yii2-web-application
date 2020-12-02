<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'enableSchemaCache' => true,
            'dsn' => 'mysql:unix_socket=' . getenv('DB_SOCKET') . ';dbname=' . getenv('DB_DBNAME'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => 'utf8',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'unixSocket' => getenv('REDIS_SOCKET'),
            'database' => null,
        ],
        'cache' => [
            'class' => 'yii\redis\Cache',
            'redis' => 'redis',
            'keyPrefix' => 'cache:',
            'defaultDuration' => 43200,
        ],
        'session' => [
            'class' => 'yii\redis\Session',
            'redis' => 'redis',
            'keyPrefix' => 'session:',
        ],
        'authManager' => [
            'cache' => 'cache',
        ],
        'mailer' => [
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
            ],
        ],
    ],
];
