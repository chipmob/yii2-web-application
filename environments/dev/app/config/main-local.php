<?php

return [
    'bootstrap' => ['debug', 'gii'],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['*'],
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['*'],
        ],
    ],
    'components' => [
        'user' => [
            'encryptKey' => getenv('COOKIE_ENCRYPT_KEY'),
        ],
        'request' => [
            'cookieValidationKey' => '',
        ],
        'authClientCollection' => [
            'clients' => [
                'google' => [
                    'class' => 'chipmob\user\components\clients\Google',
                    'clientId' => getenv('GOOGLE_CLIENT_ID'),
                    'clientSecret' => getenv('GOOGLE_CLIENT_SECRET'),
                ],
                'yandex' => [
                    'class' => 'chipmob\user\components\clients\Yandex',
                    'clientId' => getenv('YANDEX_CLIENT_ID'),
                    'clientSecret' => getenv('YANDEX_CLIENT_SECRET'),
                ],
                'facebook' => [
                    'class' => 'chipmob\user\components\clients\Facebook',
                    'clientId' => getenv('FACEBOOK_CLIENT_ID'),
                    'clientSecret' => getenv('FACEBOOK_CLIENT_SECRET'),
                ],
                'twitter' => [
                    'class' => 'chipmob\user\components\clients\Twitter',
                    'attributeParams' => ['include_email' => true, 'include_entities' => false, 'skip_status' => true],
                    'consumerKey' => getenv('TWITTER_CLIENT_ID'),
                    'consumerSecret' => getenv('TWITTER_CLIENT_SECRET'),
                ],
                'vkontakte' => [
                    'class' => 'chipmob\user\components\clients\VKontakte',
                    'clientId' => getenv('VKONTAKTE_CLIENT_ID'),
                    'clientSecret' => getenv('VKONTAKTE_CLIENT_SECRET'),
                ],
                'github' => [
                    'class' => 'chipmob\user\components\clients\GitHub',
                    'clientId' => getenv('GITHUB_CLIENT_ID'),
                    'clientSecret' => getenv('GITHUB_CLIENT_SECRET'),
                ],
                /*'linkedin' => [
                    'class' => 'chipmob\user\components\clients\LinkedIn',
                    'clientId' => getenv('LINKEDIN_CLIENT_ID'),
                    'clientSecret' => getenv('LINKEDIN_CLIENT_SECRET'),
                ],*/
            ],
        ],
    ],
];
