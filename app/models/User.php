<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * @property string $roleName
 * @property string $roleDescription
 */
class User extends \common\models\User
{
    public function getRoleName(): string
    {
        $names = ArrayHelper::getColumn($this->getRoles(), 'name');
        return empty($names) ? '-' : implode("<br>", array_values($names));
    }

    public function getRoleDescription(): string
    {
        $descriptions = ArrayHelper::getColumn($this->getRoles(), 'description');
        return empty($descriptions) ? '-' : implode("<br>", array_values($descriptions));
    }

    public static function getListOfRoles(): array
    {
        $roles = Yii::$app->authManager->getRoles();
        if (($user = Yii::$app->user->identity) instanceof self && !$user->isAdmin) {
            unset($roles[self::ROLE_ROOT]);
        }
        return ArrayHelper::map($roles, 'name', 'description');
    }

    protected function getRoles(): array
    {
        return $this->_cache->getOrSet(['User_Roles', $this->id], fn() => Yii::$app->authManager->getRolesByUser($this->id));
    }
}
