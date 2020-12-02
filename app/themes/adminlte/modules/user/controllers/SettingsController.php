<?php

namespace app\themes\adminlte\modules\user\controllers;

class SettingsController extends \chipmob\user\controllers\SettingsController
{
    /** @inheritdoc */
    public function actionProfile()
    {
        $this->setViewPath('@app/themes/adminlte/modules/user/views/settings');

        return parent::actionProfile();
    }
}
