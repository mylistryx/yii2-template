<?php

use yii\db\Connection;

return [
    'class' => Connection::class,
    'dsn' => 'mysql:host=127.0.0.1;dbname=yii2template',
    'username' => 'root',
    'password' => '123123123',
    'charset' => 'utf8mb4',
    'enableSchemaCache' => YII_DEBUG === false,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
];
