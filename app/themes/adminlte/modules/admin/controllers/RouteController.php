<?php

namespace app\themes\adminlte\modules\admin\controllers;

class RouteController extends \mdm\admin\controllers\RouteController
{
    /** @inheritdoc */
    public function actionIndex()
    {
        $this->setViewPath('@app/themes/adminlte/modules/admin/views/route');

        return parent::actionIndex();
    }
}
