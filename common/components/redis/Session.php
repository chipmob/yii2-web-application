<?php

namespace common\components\redis;

use Yii;
use yii\web\IdentityInterface;

/**
 * Redis Session implements a session component using [redis](http://redis.io/) as the storage medium.
 *
 * Redis Session requires redis version 3.0.2 or higher to work properly.
 *
 * It needs to be configured with a redis [[Connection]] that is also configured as an application component.
 * By default it will use the `redis` application component.
 *
 * To use redis Session as the session application component, configure the application as follows,
 *
 * ~~~
 * [
 *     'components' => [
 *         'session' => [
 *             'class' => 'common\components\redis\Session',
 *             // 'redis' => 'redis' // id of the connection application component
 *         ],
 *     ],
 * ]
 * ~~~
 *
 * @property String $keyPrefix is a prefix for session key in Redis storage. Separate session by Yii::$app->id (as default).
 * @property String $userKeySeparator a separator for build user key. Default ':u:'
 * @property String $sessionKeySeparator a separator for build session key. Default ':s:'
 *
 * @property array $onlineUsers All ids of user identity, who have fresh session order by user identity id
 * @property array $activeSessions All active sessions
 */
class Session extends \yii\redis\Session
{
    public string $userKeySeparator = ':u:';
    public string $sessionKeySeparator = ':s:';

    protected float $initTime;
    protected float $expiredTime;

    private array $_onlineUsers = [];
    private array $_activeSessions = [];

    /** @inheritdoc */
    public function init()
    {
        parent::init();

        $this->initTime = (float)($_SERVER["REQUEST_TIME_FLOAT"] ?? microtime(true));
        $this->expiredTime = $this->initTime - $this->timeout;
    }

    /** @inheritdoc */
    public function openSession($savePath, $sessionName)
    {
        return true;
    }

    /** @inheritdoc */
    public function closeSession()
    {
        return true;
    }

    /** @inheritdoc */
    public function readSession($id)
    {
        return parent::readSession($id);
    }

    /**
     * Write session; Also store session id and user identity id
     * @inheritdoc
     */
    public function writeSession($id, $data)
    {
        $result = parent::writeSession($id, $data);

        $userIdentity = Yii::$app->user->getIdentity(false);

        if ($result && $userIdentity instanceof IdentityInterface) {
            $result = (bool)$this->redis->zadd($this->keyUser($userIdentity->id), 'CH', $this->initTime, $id);
            $result = $result && (bool)$this->redis->set($this->keySession($id), $userIdentity->id);
        }

        return $result;
    }

    /**
     * Destroy session; Also remove session id from sorted set and user identity id
     * @inheritdoc
     */
    public function destroySession($id)
    {
        parent::destroySession($id);

        if ($userIdentityId = (int)$this->redis->get($this->keySession($id))) {
            $this->redis->zrem($this->keyUser($userIdentityId), $id);
        }
        $this->redis->del($this->keySession($id));

        return true;
    }

    /** @inheritdoc */
    public function gcSession($maxLifetime)
    {
        return $this->removeExpired();
    }

    /**
     * Destroy all of user's sessions
     * force logout on all user devices
     */
    public function destroyUserSessions(int $userIdentityId): bool
    {
        if ($sessionIds = $this->redis->zrangebyscore($this->keyUser($userIdentityId), '-inf', '+inf')) {
            foreach ($sessionIds ?? [] as $id) {
                parent::destroySession($id);
                $this->redis->del($this->keySession($id));
            }
        }
        $this->redis->del($this->keyUser($userIdentityId));

        return true;
    }

    /**
     * Destroy all expired session's dependencies
     */
    public function removeExpired(): bool
    {
        if ($keys = $this->redis->keys($this->maskUser())) {
            foreach ($keys ?? [] as $key) {
                $this->redis->multi();
                $this->redis->zrangebyscore($key, '-inf', $this->expiredTime);
                $this->redis->zremrangebyscore($key, '-inf', $this->expiredTime);
                $exec = $this->redis->exec();
                if ($sessionIds = $exec[0]) {
                    $this->redis->del(...array_map(function ($sessionId) {
                        parent::destroySession($sessionId);
                        return $this->keySession($sessionId);
                    }, $sessionIds));
                }
            }
        }

        return true;
    }

    public function getOnlineUsers(bool $cached = true): array
    {
        if ($cached && !empty($this->_onlineUsers)) {
            return $this->_onlineUsers;
        }

        $userIdentityIds = [];
        if ($keys = $this->redis->keys($this->maskUser())) {
            foreach ($keys ?? [] as $key) {
                if ($sessionIds = $this->getSessionIdsByKey($key, true)) {
                    $userIdentityIds[$this->extractUser($key)] = $sessionIds[1];
                }
            }
        }

        return $this->_onlineUsers = $userIdentityIds;
    }

    public function getActiveSessions(bool $cached = true): array
    {
        if ($cached && !empty($this->_activeSessions)) {
            return $this->_activeSessions;
        }

        $sessions = [];
        if ($keys = $this->redis->keys($this->maskUser())) {
            sort($keys, SORT_STRING);
            foreach ($keys ?? [] as $key) {
                foreach ($this->getSessionsByKey($key) as $session) {
                    $sessions[] = $session;
                }
            }
        }

        return $this->_activeSessions = $sessions;
    }

    /**
     * Get all active sessions by user identity id
     * Sorted DESC by last activity
     */
    public function getSessionsById(int $userIdentityId): array
    {
        return $this->getSessionsByKey($this->keyUser($userIdentityId));
    }

    /**
     * Get internal key for store/read a sorted list of sessions
     */
    protected function keyUser(int $userIdentityId): string
    {
        return $this->prefixUser() . $userIdentityId;
    }

    /**
     * Extract user from string key
     */
    protected function extractUser(string $key): int
    {
        return preg_replace('|' . $this->prefixUser() . '(\d+)|', '$1', $key) ?? 0;
    }

    /**
     * Get internal key mask fore read all keys in storage
     */
    protected function maskUser(): string
    {
        return $this->prefixUser() . '*';
    }

    /**
     * Return prefix for create user key
     */
    protected function prefixUser(): string
    {
        return $this->keyPrefix . $this->userKeySeparator;
    }

    /**
     * Get internal key for store/read a list of user identity id
     */
    protected function keySession(string $sessionId): string
    {
        return $this->prefixSession() . $sessionId;
    }

    /**
     * Return prefix for create session key
     */
    protected function prefixSession(): string
    {
        return $this->keyPrefix . $this->sessionKeySeparator;
    }

    /**
     * Get all active session IDs that could be stored in the redis storage
     * If withScores is true all odd elements represent a timestamp of a previous element
     */
    private function getSessionIdsByKey(string $key, bool $withScores = false): array
    {
        if ($withScores) {
            return $this->redis->zrevrangebyscore($key, $this->initTime, $this->expiredTime, 'WITHSCORES');
        }

        return $this->redis->zrevrangebyscore($key, $this->initTime, $this->expiredTime);
    }

    /**
     * Get all active sessions by internal key.
     * Sorted DESC by last activity
     */
    private function getSessionsByKey(string $key): array
    {
        $sessions = [];
        if ($current = $this->getSessionIdsByKey($key)) {
            foreach ($current as $value) {
                $sessions[] = $this->readSession($value);
            }
        }

        return $sessions;
    }
}
