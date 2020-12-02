<?php

namespace app\themes\adminlte\modules\user\components\widgets;

class AdminMenu extends \chipmob\user\components\widgets\AdminMenu
{
    /** @inheritdoc */
    public function init()
    {
        parent::init();

        $items = $this->items;
        unset($items['delete']);
        $this->items = $items;
    }
}
