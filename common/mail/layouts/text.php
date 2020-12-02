<?php

use yii\web\View;

/* @var View $this view component instance */
/* @var string $content main view render result */

$this->beginPage();
$this->beginBody();
echo $content;
$this->endBody();
$this->endPage();
