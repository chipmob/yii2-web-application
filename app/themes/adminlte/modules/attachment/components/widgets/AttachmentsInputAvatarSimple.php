<?php

namespace app\themes\adminlte\modules\attachment\components\widgets;

use chipmob\attachment\models\File;
use chipmob\attachment\components\widgets\AttachmentsInput;
use kartik\file\FileInput;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class AttachmentsInputAvatarSimple extends AttachmentsInput
{
    public $pluginOptions = [];

    /** @inheritdoc */
    public function init()
    {
        parent::init();

        $this->pluginOptions = array_replace($this->pluginOptions, [
            'uploadUrl' => Url::toRoute('upload'),
            'uploadAsync' => false,
            'maxFileCount' => $this->model->getRule('maxFiles'),
            'showClose' => false,
            'showCaption' => false,
            //'showPreview' => true, // default: true
            'showUpload' => false,
            'dropZoneEnabled' => false,
            'autoReplace' => true,
            //'previewFileType' => 'image', // default: 'image'
            'showCancel' => false,
            'showRemove' => false,
            'browseClass' => '',
            'browseLabel' => '',
            'browseIcon' => Html::tag('i', null, ['class' => 'fas fa-plus-circle']),
            'initialPreview' => $this->model->hasFiles ? Html::img($this->model->firstFile->directUrl, ['class' => 'img-rounded', 'style' => 'height: 5em;']) : Html::img(File::IMAGE_PLACEHOLDER, ['class' => 'img-rounded', 'style' => 'height: 5em;']),
            'initialPreviewConfig' => [],
        ]);

        $this->pluginOptions['layoutTemplates'] = [
            'preview' => '<div class="file-preview {class}"><div class="file-preview-thumbnails"></div><div class="clearfix"></div></div>',
        ];

        if ($this->model->hasFiles) {
            $this->pluginOptions['layoutTemplates'] += [
                'footer' => '',
                'actions' => '',
            ];
        } else {
            $this->pluginOptions['layoutTemplates'] += [
                'footer' => '',
            ];
        }

        $css = <<<CSS
.file-input .file-preview {
    width: 5em;
    height: 5em;
    display: block!important;
    background-color: white;
}
.btn-file {
    margin-top: -1em;
    margin-right: -1em;
}
.krajee-default.file-preview-frame .kv-file-content {
    width: 5em;
    height: 5em;
}
.file-input .file-preview-thumbnails {
    text-align:center;
}
.file-input .file-preview {
    border: 0; padding: 0; border-radius: 0; margin-bottom: 1em;
}
.file-input .file-preview-frame, .file-input .file-preview-frame:hover, .file-input .file-preview-frame:focus, .krajee-default.file-preview-frame:not(.file-preview-error):hover {
    border: 0; 
    padding: 0; 
    margin:0 ; 
    box-shadow: none !important; 
    display: inline-block; 
    float: none;
}
CSS;

        Yii::$app->view->registerCss($css);
    }

    /** @inheritdoc */
    public function run()
    {
        return FileInput::widget([
            'model' => $this->model,
            'attribute' => $this->attribute,
            'options' => $this->options,
            'pluginOptions' => $this->pluginOptions,
            'sortThumbs' => false,
            'showMessage' => false,
        ]);
    }
}
