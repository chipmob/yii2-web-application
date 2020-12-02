<?php

namespace app\themes\adminlte\modules\user\controllers;

use yii\web\NotFoundHttpException;

class AdminController extends \chipmob\user\controllers\AdminController
{
    /** @inheritdoc */
    public function actionIndex()
    {
        $this->setViewPath('@app/themes/adminlte/modules/user/views/admin');

        return parent::actionIndex();
    }

    /** @inheritdoc */
    public function actionDelete(int $id)
    {
        throw new NotFoundHttpException();
    }
}
