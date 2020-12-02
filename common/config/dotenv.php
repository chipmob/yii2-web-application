<?php

$dotenv = Dotenv\Dotenv::createImmutable(Yii::getAlias('@root'));
$dotenv->load();
$dotenv->required(['DB_SOCKET', 'DB_DBNAME', 'DB_USERNAME', 'DB_PASSWORD', 'REDIS_SOCKET'])->notEmpty();
