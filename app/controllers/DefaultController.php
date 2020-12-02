<?php

namespace app\controllers;

use yii\web\Controller;

/**
 * Site controller
 */
class DefaultController extends Controller
{
    /** @inheritdoc */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /** @return string */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /** @return string */
    public function actionPrivacy()
    {
        return $this->renderContent('Privacy policy text');
    }

    /** @return string */
    public function actionTerms()
    {
        return $this->renderContent('Terms of service text');
    }
}
