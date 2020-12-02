<?php

use chipmob\user\models\User as BaseUser;
use common\models\User;

return [
    BaseUser::class => [
        BaseUser::EVENT_AFTER_INSERT => [
            [User::class, 'assignRole'],
        ],
        BaseUser::EVENT_AFTER_DELETE => [
            [User::class, 'revokeAllRoles'],
        ],
        BaseUser::EVENT_SECURITY => [
            [User::class, 'destroyUserSessions'],
        ],
    ],
];
