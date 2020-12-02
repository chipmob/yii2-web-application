<?php

namespace app\themes\adminlte\modules\admin\controllers;

class AssignmentController extends \mdm\admin\controllers\AssignmentController
{
    /** @inheritdoc */
    public function actionIndex()
    {
        $this->setViewPath('@app/themes/adminlte/modules/admin/views/assignment');

        return parent::actionIndex();
    }

    /** @inheritdoc */
    public function actionView($id)
    {
        $this->setViewPath('@app/themes/adminlte/modules/admin/views/assignment');

        return parent::actionView($id);
    }
}
