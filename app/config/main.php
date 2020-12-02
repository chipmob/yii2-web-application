<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-web',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'app\controllers',
    'defaultRoute' => 'default',
    'bootstrap' => ['log', 'admin'],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'menu',
            'controllerMap' => [
                'assignment' => 'app\themes\adminlte\modules\admin\controllers\AssignmentController',
                'permission' => 'app\themes\adminlte\modules\admin\controllers\PermissionController',
                'role' => 'app\themes\adminlte\modules\admin\controllers\RoleController',
                'route' => 'app\themes\adminlte\modules\admin\controllers\RouteController',
                'menu' => 'app\themes\adminlte\modules\admin\controllers\MenuController',
            ],
        ],
        'user' => [
            'class' => 'chipmob\user\Module',
            'modelMap' => [
                'User' => 'app\models\User',
                'Profile' => 'app\models\Profile',
                'UserSearch' => 'app\models\search\UserSearch',
            ],
            'controllerMap' => [
                'admin' => 'app\themes\adminlte\modules\user\controllers\AdminController',
                'settings' => 'app\themes\adminlte\modules\user\controllers\SettingsController',
            ],
        ],
        'attachment' => [
            'class' => 'chipmob\attachment\Module',
            'tempPath' => '@app/web/uploads/temp',
            'storePath' => '@app/web/uploads/store',
            'rules' => [
                'maxFiles' => 8,
                'mimeTypes' => [
                    'image/*', 'application/msword', 'application/vnd.ms-excel', 'text/plain', 'application/pdf', 'application/zip', 'application/x-rar-compressed',
                ],
                'maxSize' => 2 * 1024 * 1024,
            ],
            'controllerMap' => [
                'file' => 'app\themes\adminlte\modules\attachment\controllers\FileController',
            ],
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
    ],
    'components' => [
        'user' => [
            'class' => 'common\components\web\User',
            'enableAutoLogin' => true,
        ],
        'session' => [
            'name' => '_session',
        ],
        'errorHandler' => [
            'errorAction' => 'default/error',
            'maxSourceLines' => 0,
            'maxTraceSourceLines' => 0,
            'displayVars' => [],
        ],
        'assetManager' => [
            'linkAssets' => true,
            'assetMap' => [],
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [YII_DEBUG ? 'jquery.js' : 'jquery.min.js'],
                ],
                'yii\bootstrap4\BootstrapAsset' => [
                    'css' => [YII_DEBUG ? 'css/bootstrap.css' : 'css/bootstrap.min.css'],
                ],
                'yii\bootstrap4\BootstrapPluginAsset' => [
                    'js' => [YII_DEBUG ? 'js/bootstrap.bundle.js' : 'js/bootstrap.bundle.min.js'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'privacy' => 'default/privacy',
                'terms' => 'default/terms',
                '<module:admin>/<controller:user>' => 'default/error',
                '<module:admin>/<controller:user>/<action:\w*>' => 'default/error',
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/adminlte/views',
                    '@mdm/admin/views/layouts' => '@app/themes/adminlte/modules/admin/views/layouts',
                ],
            ],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
        ],
    ],
    'container' => [
        'definitions' => [
            'yii\base\Widget' => 'kartik\base\Widget',
            'yii\grid\GridView' => 'kartik\grid\GridView',
            'yii\grid\ActionColumn' => ['class' => 'kartik\grid\ActionColumn', 'hAlign' => 'right', 'noWrap' => true],
            'yii\grid\CheckboxColumn' => 'kartik\grid\CheckboxColumn',
            'yii\grid\DataColumn' => 'kartik\grid\DataColumn',
            'yii\grid\RadioButtonColumn' => 'kartik\grid\RadioButtonColumn',
            'yii\grid\SerialColumn' => 'kartik\grid\SerialColumn',
            'kartik\daterange\DateRangePicker' => [
                'class' => 'common\components\widgets\DateRangePicker',
                'convertFormat' => true,
                'useWithAddon' => true,
                'autoUpdateOnInit' => true,
                //'presetDropdown' => true,
            ],
            'chipmob\user\components\widgets\AdminMenu' => 'app\themes\adminlte\modules\user\components\widgets\AdminMenu',
        ],
    ],
    'on beforeRequest' => function () {
        if (($user = Yii::$app->user->identity) instanceof \app\models\User && ($user->isBlocked || $user->isRemoved)) {
            Yii::$app->user->logout();
        }
        if (Yii::$app->user->isGuest) {
            Yii::$app->view->theme->pathMap['@app/views'] = '@app/themes/basic/views';
        }
    },
    'as access' => [
        'class' => 'common\components\AccessControl',
        'allowActions' => [
            'debug/*',
            'attachment/file/*',
            'user/recovery/*',
            'user/registration/*',
            'user/security/*',
            'user/settings/*',
            'user/admin/switch',
            'default/*',
        ],
    ],
    'params' => $params,
];
