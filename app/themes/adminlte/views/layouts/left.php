<?php

use dmstr\adminlte\widgets\Menu;
use mdm\admin\components\MenuHelper;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */

$css = <<<CSS
.sidebar-collapse .user-panel {
    display: none;
}
CSS;
$this->registerCss($css);

$callback = function ($menu) {
    $item = [
        'label' => $menu['name'],
        'url' => MenuHelper::parseRoute($menu['route']),
    ];
    if ($menu['children'] != []) {
        $item['items'] = $menu['children'];
    }
    if (is_array($data = eval($menu['data']))) {
        foreach ($data as $key => $value) {
            $item[$key] = $value;
        }
    }
    return $item;
}
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <?= Html::a(Html::tag('span', Html::img(Yii::$app->user->identity->profile->avatar, ['width' => 24, 'height' => 24]), ['class' => 'brand-image img-circle elevation-3']) . Html::tag('span', Yii::$app->name, ['class' => 'brand-text font-weight-light']), Yii::$app->homeUrl, ['class' => 'brand-link']) ?>
    <div class="sidebar">
        <div class="user-panel text-white bg-dark text-center">
            <h3><?= Yii::$app->user->identity->name ?></h3>
            <p><?= Yii::$app->user->identity->email ?></p>
        </div>
        <nav class="mt-2">
            <?= Menu::widget([
                'options' => ['class' => 'nav nav-pills nav-sidebar flex-column', 'data-widget' => 'treeview'],
                'items' => array_merge(
                    [
                        ['label' => Yii::t('common', 'Меню'), 'header' => true],
                        ['label' => 'Gii', 'icon' => 'file-code', 'url' => ['/gii'], 'visible' => Yii::$app->hasModule('gii') && YII_DEBUG === true],
                        ['label' => 'Debug', 'icon' => 'tachometer-alt', 'url' => ['/debug'], 'visible' => Yii::$app->hasModule('debug') && YII_DEBUG === true],
                    ],
                    MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback)
                ),
            ]) ?>
        </nav>
    </div>
</aside>
