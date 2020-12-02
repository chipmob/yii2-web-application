<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $name string */

$this->title = $name;
?>
<div class="error-page">
    <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>
    <div class="error-content">
        <h3><?= $this->title ?></h3>
        <p>
            <?= nl2br(Html::encode($this->title)) ?>
        </p>
        <p>
            The above error occurred while the Web server was processing your request.
            Please contact us if you think this is a server error.
            Thank you. Meanwhile, you may <?= Html::a('return to dashboard', Yii::$app->homeUrl) ?>.
        </p>
    </div>
</div>
