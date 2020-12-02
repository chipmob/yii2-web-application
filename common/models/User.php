<?php

namespace common\models;

use Yii;
use yii\base\Event;
use yii\caching\ArrayCache;
use yii\caching\CacheInterface;
use yii\db\AfterSaveEvent;

class User extends \chipmob\user\models\User
{
    const ROLE_GUEST = 'guest';
    const ROLE_ROOT = 'root';

    protected CacheInterface $_cache;

    /** @inheritdoc */
    public function init()
    {
        parent::init();

        $this->_cache = Yii::createObject(ArrayCache::class);
    }

    public static function destroyUserSessions(Event $event)
    {
        /** @var self $user */
        $user = $event->sender;
        Yii::$app->session->destroyUserSessions($user->id);
    }

    public static function assignRole(AfterSaveEvent $event)
    {
        /** @var self $user */
        $user = $event->sender;
        if ($role = Yii::$app->authManager->getRole(self::ROLE_GUEST)) {
            Yii::$app->authManager->assign($role, $user->id);
        }
    }

    public static function revokeAllRoles(Event $event)
    {
        /** @var self $user */
        $user = $event->sender;
        Yii::$app->authManager->revokeAll($user->id);
    }
}
