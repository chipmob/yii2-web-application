<?php

use dmstr\adminlte\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\helpers\Inflector;

/* @var $this yii\web\View */
/* @var $content string */

?>
<main class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <?php if ($this->title !== null) {
                            echo Html::encode($this->title);
                        } else {
                            echo Inflector::camel2words(Inflector::id2camel($this->context->module->id));
                            if ($this->context->module->id !== Yii::$app->id) echo "&nbsp;Module";
                        } ?>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], 'options' => ['class' => 'float-sm-right']]); ?>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</main>
<!--<aside class="control-sidebar control-sidebar-dark">
    <div class="p-3 control-sidebar-content">
        <h5>Customize</h5>
    </div>
</aside>
<div class="control-sidebar-bg"></div>-->
<footer class="main-footer">
    <div class="text-bold text-nowrap"><?= Html::encode(Yii::$app->name) ?>&nbsp;&copy;&nbsp;<?= date('Y') ?></div>
</footer>
