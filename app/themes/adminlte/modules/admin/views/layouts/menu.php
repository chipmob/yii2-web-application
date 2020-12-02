<?php

use yii\bootstrap4\Nav;

/* @var $this yii\web\View */
/* @var $content string */

$this->beginContent('@app/views/layouts/main.php');

echo Nav::widget([
    'options' => ['class' => 'nav-tabs mb-3'],
    'items' => [
        [
            'label' => Yii::t('rbac-admin', 'Assignments'),
            'url' => ['/admin/assignment/index'],
        ],
        [
            'label' => Yii::t('rbac-admin', 'Roles'),
            'url' => ['/admin/role/index'],
        ],
        [
            'label' => Yii::t('rbac-admin', 'Permissions'),
            'url' => ['/admin/permission/index'],
        ],
        [
            'label' => Yii::t('rbac-admin', 'Routes'),
            'url' => ['/admin/route/index'],
        ],
        [
            'label' => Yii::t('rbac-admin', 'Menu'),
            'url' => ['/admin/menu/index'],
        ],
        [
            'label' => Yii::t('rbac-admin', 'Create'),
            'items' => [
                [
                    'label' => Yii::t('rbac-admin', 'Create Role'),
                    'url' => ['/admin/role/create'],
                ],
                [
                    'label' => Yii::t('rbac-admin', 'Create Permission'),
                    'url' => ['/admin/permission/create'],
                ],
                [
                    'label' => Yii::t('rbac-admin', 'Create Menu'),
                    'url' => ['/admin/menu/create'],
                ],
            ],
        ],
    ],
]);

echo $content;

$this->endContent();
