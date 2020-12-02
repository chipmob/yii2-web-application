<?php

namespace common\components\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

class DateRangePicker extends \kartik\daterange\DateRangePicker
{
    public string $addonTemplate = <<<HTML
<div class="input-group drp-container">
    <div class="input-group-prepend">
        <span class="input-group-text">
            <i class="fas fa-calendar-alt"></i>
        </span>
    </div>
    {input}
</div>
HTML;

    /** @inheritdoc */
    public function run()
    {
        $this->pluginOptions = ArrayHelper::merge(self::getDefaultPluginOptions(), $this->pluginOptions);
        $this->pluginEvents = ArrayHelper::merge(self::getDefaultPluginEvents(), $this->pluginEvents);

        parent::run();
    }

    public static function getDefaultPluginOptions(): array
    {
        return [
            'minDate' => '01.09.2020',
            'maxDate' => new JsExpression('moment().format("DD.MM.YYYY")'),
            'locale' => [
                'firstDay' => 1,
                'format' => 'd.m.Y',
                'applyLabel' => Yii::t('common', 'Применить'),
                'cancelLabel' => Yii::t('common', 'Сбросить'),
                'fromLabel' => Yii::t('common', 'С'),
                'toLabel' => Yii::t('common', 'До'),
                'customRangeLabel' => Yii::t('common', 'Другой'),
                'weekLabel' => 'Н',
                'daysOfWeek' => [
                    Yii::t('common', 'Вс'),
                    Yii::t('common', 'Пн'),
                    Yii::t('common', 'Вт'),
                    Yii::t('common', 'Ср'),
                    Yii::t('common', 'Чт'),
                    Yii::t('common', 'Пт'),
                    Yii::t('common', 'Сб'),
                ],
                'monthNames' => [
                    Yii::t('common', 'Январь'),
                    Yii::t('common', 'Февраль'),
                    Yii::t('common', 'Март'),
                    Yii::t('common', 'Апрель'),
                    Yii::t('common', 'Май'),
                    Yii::t('common', 'Июнь'),
                    Yii::t('common', 'Июль'),
                    Yii::t('common', 'Август'),
                    Yii::t('common', 'Сентябрь'),
                    Yii::t('common', 'Октябрь'),
                    Yii::t('common', 'Ноябрь'),
                    Yii::t('common', 'Декабрь'),
                ],

            ],
            'alwaysShowCalendars' => true,
            'ranges' => [
                Yii::t('common', 'Сегодня') => ["moment().startOf('day')", "moment()"],
                Yii::t('common', 'Вчера') => ["moment().startOf('day').subtract(1,'days')", "moment().endOf('day').subtract(1,'days')"],
                Yii::t('common', 'Последние {n} дней', ['n' => 7]) => ["moment().startOf('day').subtract(6, 'days')", "moment()"],
                Yii::t('common', 'Последние {n} дней', ['n' => 30]) => ["moment().startOf('day').subtract(29, 'days')", "moment()"],
                Yii::t('common', 'Текущий месяц') => ["moment().startOf('month')", "moment().endOf('month')"],
                Yii::t('common', 'Прошлый месяц') => ["moment().subtract(1, 'month').startOf('month')", "moment().subtract(1, 'month').endOf('month')"],
                Yii::t('common', 'Текущий год') => ["moment().startOf('year')", "moment()"],
                Yii::t('common', 'За всё время') => ["moment('01.09.2020', 'DD.MM.YYYY')", "moment()"],
            ],
            'showCustomRangeLabel' => false,
        ];
    }

    public static function getDefaultPluginEvents(): array
    {
        return [
            'cancel.daterangepicker' => 'function(ev, picker) {
                    var input = $(picker.element).find("input");
                    input.val("");
                    input.trigger("change");
                }',
        ];
    }

    /** @inheritdoc */
    protected function renderInput()
    {
        $content = parent::renderInput();

        if (!$this->useWithAddon || $this->presetDropdown || $this->hideInput) {
            return $content;
        } else {
            return str_replace('{input}', $content, $this->addonTemplate);
        }
    }
}
