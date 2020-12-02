<?php

namespace app\themes\adminlte\modules\admin\controllers;

use yii\base\Controller;

class MenuController extends \mdm\admin\controllers\MenuController
{
    /** @inheritdoc */
    public function actionIndex()
    {
        $this->setViewPath('@app/themes/adminlte/modules/admin/views/menu');

        return parent::actionIndex();
    }

    /** @inheritdoc */
    public function actionView($id)
    {
        $this->setViewPath('@app/themes/adminlte/modules/admin/views/menu');

        return parent::actionView($id);
    }

    /** @inheritdoc */
    public function actionCreate()
    {
        $this->setViewPath('@app/themes/adminlte/modules/admin/views/menu');

        return parent::actionCreate();
    }

    /** @inheritdoc */
    public function actionUpdate($id)
    {
        $this->setViewPath('@app/themes/adminlte/modules/admin/views/menu');

        return parent::actionUpdate($id);
    }

    public function getViewPath()
    {
        return Controller::getViewPath();
    }
}
