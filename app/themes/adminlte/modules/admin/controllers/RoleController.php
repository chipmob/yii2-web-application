<?php

namespace app\themes\adminlte\modules\admin\controllers;

use yii\base\Controller;

class RoleController extends \mdm\admin\controllers\RoleController
{
    /** @inheritdoc */
    public function actionIndex()
    {
        $this->setViewPath('@app/themes/adminlte/modules/admin/views/item');

        return parent::actionIndex();
    }

    /** @inheritdoc */
    public function actionView($id)
    {
        $this->setViewPath('@app/themes/adminlte/modules/admin/views/item');

        return parent::actionView($id);
    }

    /** @inheritdoc */
    public function actionCreate()
    {
        $this->setViewPath('@app/themes/adminlte/modules/admin/views/item');

        return parent::actionCreate();
    }

    /** @inheritdoc */
    public function actionUpdate($id)
    {
        $this->setViewPath('@app/themes/adminlte/modules/admin/views/item');

        return parent::actionUpdate($id);
    }

    public function getViewPath()
    {
        return Controller::getViewPath();
    }
}
