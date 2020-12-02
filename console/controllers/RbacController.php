<?php

namespace console\controllers;

use common\models\User;
use Yii;
use yii\helpers\Console;

class RbacController extends ConsoleController
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();

        $rootRole = $auth->createRole('root');
        $rootRole->description = 'Суперпользователь';
        $auth->add($rootRole);

        $guestRole = $auth->createRole('guest');
        $guestRole->description = 'Гость';
        $auth->add($guestRole);

        $rootPermission = $auth->createPermission('RootPermission');
        $rootPermission->description = 'Права суперпользователя';
        $auth->add($rootPermission);

        $auth->addChild($rootRole, $rootPermission);

        $userRoute = $auth->createPermission('/user/admin');
        $auth->add($userRoute);

        $rbacRoute = $auth->createPermission('/admin');
        $auth->add($rbacRoute);

        $anyRoute = $auth->createPermission('/*');
        $auth->add($anyRoute);

        $auth->addChild($rootPermission, $anyRoute);
    }

    public function actionAssign(string $search, string $role)
    {
        $user = Yii::$container->get('UserQuery')->byUsernameOrEmail($search)->one();
        if ($user instanceof User) {
            $auth = Yii::$app->authManager;
            if (array_key_exists($role, $auth->getRolesByUser($user->id))) {
                $this->stdout(Yii::t('common', 'Роль уже назначена') . PHP_EOL, Console::FG_YELLOW);
            } elseif ($role_ = $auth->getRole($role)) {
                $auth->revokeAll($user->id);
                $auth->assign($role_, $user->id);
                $this->stdout(Yii::t('common', 'Роль назначена') . PHP_EOL, Console::FG_GREEN);
            } else {
                $this->stdout(Yii::t('common', 'Роль не найдена') . PHP_EOL, Console::FG_RED);
            }
        } else {
            $this->stdout(Yii::t('user', 'User is not found') . PHP_EOL, Console::FG_RED);
        }
    }
}
