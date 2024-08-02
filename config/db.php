<?php

use yii\db\Connection;

return [
    'class' => Connection::class,
    'dsn' => 'mysql:host=127.0.0.1;dbname=yii2basic',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'enableSchemaCache' => YII_ENV_DEV,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
];
