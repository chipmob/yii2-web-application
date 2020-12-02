<?php

namespace common\components\web;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\InvalidValueException;
use yii\helpers\Json;
use yii\web\Cookie;
use yii\web\IdentityInterface;

class User extends \yii\web\User
{
    public ?string $encryptKey = null;

    /** @inheritdoc */
    protected function renewIdentityCookie()
    {
        if (empty($this->encryptKey)) {
            parent::renewIdentityCookie();
            return;
        }

        $value = Yii::$app->getRequest()->getCookies()->getValue($this->identityCookie['name']);
        if ($value === null) {
            return;
        }

        try {
            $data = Json::decode(Yii::$app->getSecurity()->decryptByKey($value, $this->encryptKey));
        } catch (InvalidArgumentException $e) {
            $this->removeIdentityCookie();
            $data = [];
        }

        if (isset($data[3])) {
            /** @var Cookie $cookie */
            $cookie = Yii::createObject(array_merge($this->identityCookie, [
                'class' => 'yii\web\Cookie',
                'value' => Yii::$app->getSecurity()->encryptByKey(Json::encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), $this->encryptKey),
                'expire' => time() + (int)$data[2],
            ]));
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }
    }

    /** @inheritdoc */
    protected function sendIdentityCookie($identity, $duration)
    {
        if (empty($this->encryptKey)) {
            parent::sendIdentityCookie($identity, $duration);
            return;
        }

        /** @var Cookie $cookie */
        $cookie = Yii::createObject(array_merge($this->identityCookie, [
            'class' => 'yii\web\Cookie',
            'value' => Yii::$app->getSecurity()->encryptByKey(Json::encode([
                $identity->getId(),
                $identity->getAuthKey(),
                $duration,
                time() + $duration,
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), $this->encryptKey),
            'expire' => time() + $duration,
        ]));
        Yii::$app->getResponse()->getCookies()->add($cookie);
    }

    /** @inheritdoc */
    protected function getIdentityAndDurationFromCookie()
    {
        if (empty($this->encryptKey)) {
            return parent::getIdentityAndDurationFromCookie();
        }

        $value = Yii::$app->getRequest()->getCookies()->getValue($this->identityCookie['name']);
        if ($value === null) {
            return null;
        }

        try {
            $data = Json::decode(Yii::$app->getSecurity()->decryptByKey($value, $this->encryptKey));
        } catch (InvalidArgumentException $e) {
            $data = [];
        }

        if (count($data) == 4) {
            $realTimeLife = array_pop($data);
            if ($realTimeLife < time()) {
                $this->removeIdentityCookie();
                return null;
            }
            list($id, $authKey, $duration) = $data;
            /* @var $class IdentityInterface */
            $class = $this->identityClass;
            $identity = $class::findIdentity($id);
            if ($identity !== null) {
                if (!$identity instanceof IdentityInterface) {
                    throw new InvalidValueException("$class::findIdentity() must return an object implementing IdentityInterface.");
                } elseif (!$identity->validateAuthKey($authKey)) {
                    Yii::warning("Invalid auth key attempted for user '$id': $authKey", __METHOD__);
                } else {
                    return ['identity' => $identity, 'duration' => $duration];
                }
            }
        }

        $this->removeIdentityCookie();
        return null;
    }
}
