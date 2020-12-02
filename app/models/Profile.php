<?php

namespace app\models;

use chipmob\attachment\components\behaviors\FileBehavior;
use chipmob\attachment\models\File;
use Yii;

/**
 * @property string $avatar
 */
class Profile extends \chipmob\user\models\Profile
{
    /** @inheritdoc */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => FileBehavior::class,
                'rules' => [
                    'maxFiles' => 1,
                    'mimeTypes' => ['image/*'],
                    'extensions' => ['jpg', 'png', 'gif'],
                    'maxSize' => 256 * 1024,
                    'wrongMimeType' => Yii::t('attachment', 'Incorrect file format'),
                ],
            ],
        ]);
    }

    public function getAvatar(): string
    {
        /** @var File $image */
        if ($image = $this->firstFile) {
            return $image->directUrl;
        } else {
            return File::IMAGE_PLACEHOLDER;
        }
    }
}
