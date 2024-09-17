<?php

use app\models\Identity;
use yii\symfonymailer\Mailer;
use yii\symfonymailer\Message;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'language' => 'en-US',
    'components' => [
        'db' => $db,
        'mailer' => [
            'class' => Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
            'messageClass' => Message::class,
        ],
        'assetManager' => [
            'basePath' => dirname(__DIR__) . '/web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'user' => [
            'identityClass' => Identity::class,
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
        ],
    ],
    'params' => $params,
];
