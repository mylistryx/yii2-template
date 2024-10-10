<?php

namespace app\services;

use app\components\exceptions\AlreadyLoggedInException;
use app\forms\LoginForm;
use Yii;
use yii\web\User;

class AuthService
{
    public function login(User $user, LoginForm $model): bool
    {
        if (!$user->isGuest) {
            throw new AlreadyLoggedInException();
        }

        $model->validateOrPanic();

        return $user->login(
            $model->identity,
            $model->rememberMe ? Yii::$app->params['identity.rememberMeDuration'] : 0,
        );
    }

    public function logout(User $user, $destroySession = true): bool
    {
        return $user->logout($destroySession);
    }
}