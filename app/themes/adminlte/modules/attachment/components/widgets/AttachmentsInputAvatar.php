<?php

namespace app\themes\adminlte\modules\attachment\components\widgets;

use chipmob\attachment\models\File;
use chipmob\attachment\components\widgets\AttachmentsInput;
use kartik\file\FileInput;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class AttachmentsInputAvatar extends AttachmentsInput
{
    public array $pluginOptions = [];

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
            'initialPreview' => $this->model->hasFiles ? Html::img($this->model->firstFile->directUrl, ['class' => 'file-preview-image', 'style' => 'height: 10em;']) : Html::img(File::IMAGE_PLACEHOLDER, ['style' => 'height: 10em;']),
            'initialPreviewConfig' => $this->model->hasFiles ? $this->model->initialPreviewConfig : [],
        ]);

        $this->pluginOptions['layoutTemplates'] = [
            'preview' => '<div class="file-preview {class}"><div class="file-preview-thumbnails"></div><div class="clearfix"></div></div>',
        ];

        if ($this->model->hasFiles) {
            $this->pluginOptions['layoutTemplates'] += [
                'footer' => '{actions}',
                'actions' => '{delete}',
            ];
        } else {
            $this->pluginOptions['layoutTemplates'] += [
                'footer' => '',
            ];
        }

        $css = <<<CSS
.file-input .file-preview {
    height: 12em;
    display: block!important;
    background-color: rgba(128, 128, 128, 0.25);
}
.file-input .file-preview-thumbnails {
    text-align:center;
}
.file-input .file-preview {
    border: 0; padding: 0; border-radius: 0; margin-bottom: 1em;
}
.file-input .file-preview-frame, .file-input .file-preview-frame:hover {
    border: 0; padding: 0; margin:0 ; box-shadow: none !important; display: inline-block; float: none;
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
