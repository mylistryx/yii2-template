<?php

namespace app\services;

use app\components\exceptions\AlreadyLoggedInException;
use app\forms\LoginForm;
use Yii;
use yii\web\User;

class AuthService
{
    public function login(User $user, LoginForm $model): void
    {
        if (!$user->isGuest) {
            throw new AlreadyLoggedInException();
        }

        $model->validateOrPanic();

        $user->login(
            $model->identity,
            $model->rememberMe ? Yii::$app->params['identity.rememberMeDuration'] : 0,
        );
    }

    public function logout(User $user): void
    {
        $user->logout();
    }
}