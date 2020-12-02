<?php

return [
    'bootstrap' => ['gii'],
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\faker\FixtureController',
            'namespace' => 'console\fixtures',
            'templatePath' => '@console/fixtures/templates',
            'fixtureDataPath' => '@console/fixtures/data',
        ],
    ],
];
