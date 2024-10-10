<?php

namespace app\services;

use app\forms\LoginForm;
use Yii;

class IdentityAuthService
{
    public function login(LoginForm $model): bool
    {
        $model->validateOrPanic();
        $duration = $model->rememberMe ? Yii::$app->params['identity.rememberMeDuration'] : 0;
        return Yii::$app->user->login($model->identity, $duration);
    }

    public function logout($destroySession = true): bool
    {
        return Yii::$app->user->logout($destroySession);
    }
}