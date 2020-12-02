<?php

namespace app\themes\adminlte\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/adminlte/assets/sources/assets';
    public $css = [
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700',
    ];
    public $js = [
    ];
    public $depends = [
        'dmstr\adminlte\web\AdminLteAsset',
        'dmstr\adminlte\web\FontAwesomeAsset',
    ];
}
