<?php

/* @var $this yii\web\View */
/* @var $content string */

use app\themes\basic\assets\AppAsset;
use common\components\widgets\Alert;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column min-vh-100">
<?php $this->beginBody() ?>
<header class="container">
    <?php NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-dark bg-dark navbar-expand-lg mb-3'],
        'renderInnerContainer' => false,
    ]);
    echo Nav::widget([
        'items' => [
            ['label' => '&starf;', 'url' => ['/default/index'], 'encode' => false],
            ['label' => Yii::t('user', 'Sign up'), 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest],
            ['label' => Yii::t('user', 'Sign in'), 'url' => ['/user/security/login'], 'visible' => Yii::$app->user->isGuest],
            ['label' => Yii::t('user', 'Logout'), 'url' => ['/user/security/logout'], 'linkOptions' => ['data-method' => 'post'], 'visible' => !Yii::$app->user->isGuest],
        ],
        'options' => ['class' => 'navbar-nav ml-auto'],
    ]);
    NavBar::end(); ?>
</header>
<main class="container flex-fill">
    <?= Alert::widget() ?>
    <?= $content ?>
</main>
<footer class="container align-self-end">
    <div class="clearfix bg-dark text-light p-3 mt-3">
        <p class="h5 mb-0 float-left text-nowrap"><?= Html::encode(Yii::$app->name) ?> &copy; <?= date('Y') ?></p>
        <p class="h5 mb-0 float-right">&Yopf;&iopf;&iopf;&check;</p>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
