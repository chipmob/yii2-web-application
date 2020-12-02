<?php

use common\models\User;
use yii\bootstrap4\Html;

?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/" class="nav-link">Home</a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <!--<li class="nav-item dropdown">
            <a href="#" class="nav-link" data-toggle="dropdown" aria-expanded="false"><i class="far fa-comments"></i><span class="badge badge-danger navbar-badge">1</span></a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <div class="media">
                        <img class="img-size-50 img-circle mr-3" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNsqAcAAYUBAdpOiIkAAAAASUVORK5CYII=" alt="User Avatar"/>
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                User
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Message text</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 1 Hour Ago</p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="javascript::" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>-->
        <!--<li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown"><i class="far fa-bell"></i><span class="badge badge-warning navbar-badge">1</span></a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-header">1 Notification</span>
                <div class="dropdown-divider"></div>
                <a href="javascript::" class="dropdown-item"><i class="fas fa-envelope mr-2"></i> 1 new message<span class="float-right text-muted text-sm">5 min</span></a>
                <div class="dropdown-divider"></div>
            </div>
        </li>-->
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img class="user-image img-circle elevation-2" src="<?= Yii::$app->user->identity->profile->avatar ?>" alt="User Image"/>
                <span class="d-none d-md-inline"><?= Yii::$app->user->identity->name ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <li class="user-header bg-primary">
                    <img class="img-circle elevation-2" src="<?= Yii::$app->user->identity->profile->avatar ?>" alt="User Image"/>
                    <p><?= Yii::$app->user->identity->name ?></p>
                </li>
                <li class="user-body">
                    <div class="row">
                        <div class="col-4 text-center"><a href="javascript::">Link</a></div>
                        <div class="col-4 text-center"><a href="javascript::">Link</a></div>
                        <div class="col-4 text-center"><a href="javascript::">Link</a></div>
                    </div>
                </li>
                <li class="user-footer"> <!-- TODO: make widget -->
                    <?= Html::a(Yii::t('user', 'Profile'), ['/user/settings'], ['class' => 'btn btn-default btn-flat float-left']) ?>
                    <?php if (Yii::$app->hasModule('user') && Yii::$app->session->has(User::ORIGINAL_USER_SESSION_KEY)): ?>
                        <?= Html::a(Yii::t('user', 'Return'), ['/user/admin/switch'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat float-right']) ?>
                    <?php else: ?>
                        <?= Html::a(Yii::t('user', 'Logout'), ['/user/security/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat float-right']) ?>
                    <?php endif; ?>
                </li>
            </ul>
        </li>
        <!--<li class="nav-item">
            <a href="#" class="nav-link" data-widget="control-sidebar" data-slide="true"><i class="fas fa-th-large"></i></a>
        </li>-->
    </ul>
</nav>
