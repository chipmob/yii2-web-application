<?php

namespace console\fixtures;

use mdm\admin\models\Menu;
use yii\test\ActiveFixture;

class MenuFixture extends ActiveFixture
{
    /** @inheritdoc */
    public $modelClass = Menu::class;
}
