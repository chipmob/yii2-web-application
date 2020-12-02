<?php

namespace common\components;

use app\models\User;
use yii\base\Module;

class AccessControl extends \mdm\admin\components\AccessControl
{
    /** @inheritdoc */
    public function beforeAction($action)
    {
        if ($this->user->identity instanceof User && $this->user->identity->isAdmin) {
            return true;
        }

        if ($action->controller->module instanceof Module && in_array($action->controller->module->id, ['gii', 'debug']) && YII_DEBUG === true) {
            return true;
        }

        return parent::beforeAction($action);
    }
}
