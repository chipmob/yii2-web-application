<?php

use app\themes\adminlte\modules\attachment\components\widgets\AttachmentsInputAvatar;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Profile $model
 */

$this->title = Yii::t('user', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;

$this->beginContent('@user/views/settings/_layout.php');

$form = ActiveForm::begin([
    'id' => 'profile-form',
    'options' => ['class' => 'form-horizontal'],
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'validateOnBlur' => false,
]);
echo $form->field($model, 'name')->textInput();
echo $form->field($model, 'file[]')->widget(AttachmentsInputAvatar::class)->label(Yii::t('common', 'Аватар'));
echo $form->field($model, 'public_email')->input('email');
echo $form->field($model, 'website')->input('url');
echo $form->field($model, 'location')->textInput([]);
echo $form->field($model, 'timezone')->dropDownList($model::getTimezoneList());
echo Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']);
ActiveForm::end();

$this->endContent();
