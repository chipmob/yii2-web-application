<?php

return [
    [
        'id' => 1,
        'name' => 'Система',
        'data' => 'return ["icon" => "cogs"];',
    ],
    [
        'id' => 2,
        'name' => 'Пользователи',
        'parent' => 1,
        'route' => '/user/admin',
        'order' => 1,
        'data' => 'return ["icon" => "user-cog"];',
    ],
    [
        'id' => 3,
        'name' => 'Права',
        'parent' => 1,
        'route' => '/admin',
        'order' => 2,
        'data' => 'return ["icon" => "user-shield"];',
    ],
];
