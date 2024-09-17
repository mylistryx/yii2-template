<?php

use app\models\Identity;
use yii\console\Application as ConsoleApplication;
use yii\rbac\DbManager;
use yii\web\Application as WebApplication;
use yii\web\User;

class Yii
{
    public static ConsoleApplication|__Application|WebApplication $app;
}

/**
 * @property DbManager $authManager
 * @property User|__WebUser $user
 *
 */
class __Application
{
}

/**
 * @property Identity $identity
 */
class __WebUser
{
}
