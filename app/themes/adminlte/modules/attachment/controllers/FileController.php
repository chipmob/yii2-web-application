<?php

namespace app\themes\adminlte\modules\attachment\controllers;

use app\models\User;
use chipmob\attachment\models\File;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class FileController extends \chipmob\attachment\controllers\FileController
{
    public function actionDelete(string $id): bool
    {
        if (empty($file = File::findOne($id))) {
            throw new NotFoundHttpException(Yii::t('attachment', 'File not found'));
        }

        $user = Yii::$app->user->identity;
        if ($user instanceof User && !$user->isAdmin && $user->id !== $file->created_by) {
            throw new ForbiddenHttpException(Yii::t('attachment', 'You are not the owner of this file'));
        }

        return $this->module->detachFile($id);
    }
}
