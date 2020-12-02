<?php

namespace common\components;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Module;
use yii\helpers\ArrayHelper;

class Bootstrap implements BootstrapInterface
{
    /** @inheritdoc */
    public function bootstrap($app)
    {
        $rootNamespace = str_replace('\Bootstrap', '', get_class($this));
        $slices = explode('\\', $rootNamespace);
        $moduleName = end($slices);
        //$pathOfAlias = Yii::getAlias('@' . strtr($rootNamespace, '\\', '/'));

        if ($app->hasModule($moduleName)) {

            if (!isset($app->i18n->translations[$moduleName . '*'])) {
                $app->i18n->translations[$moduleName . '*'] = [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => Yii::getAlias('@common/messages'),
                    'sourceLanguage' => 'ru-RU',
                ];
            }

            /** @var Module $module */
            $module = $app->getModule($moduleName);

            if ($app instanceof yii\console\Application) {
                $module->controllerNamespace = $rootNamespace . '\commands';
            } else {
                if (property_exists($module, 'urlPrefix') && property_exists($module, 'urlRules')) {
                    $array = explode('/', Yii::getAlias('@app'));
                    $application = end($array);
                    $configUrlRule = [
                        'class' => 'yii\web\GroupUrlRule',
                        'prefix' => $module->urlPrefix,
                        'rules' => ArrayHelper::merge($module->urlRules, [
                            "module/<module>/<controller>/<action>" => "$application/<module>/<controller>/<action>",
                            "module/<controller>/<action>" => "$application/<controller>/<action>",
                            "module/<controller>" => "$application/<controller>",
                        ]),
                    ];
                    if ($module->urlPrefix != $moduleName) {
                        $configUrlRule['routePrefix'] = $moduleName;
                    }
                    $rule = Yii::createObject($configUrlRule);
                    $app->urlManager->addRules([$rule], false);
                }
            }
        }
    }
}
