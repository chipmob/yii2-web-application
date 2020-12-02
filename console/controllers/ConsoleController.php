<?php

namespace console\controllers;

use yii\console\Controller;

abstract class ConsoleController extends Controller
{
    /** @inheritdoc */
    public function init()
    {
        parent::init();

        set_time_limit(0);
        ini_set('memory_limit', '1G');
    }
}
