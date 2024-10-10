<?php

namespace app\forms;

use app\components\forms\Form;
use app\models\Identity;
use Yii;

class SignupForm extends Form
{
    public ?string $email = null;
    public ?string $password = null;

    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'string', 'min' => Yii::$app->params['identity.minPasswordLength']],
            ['email', 'unique', 'targetClass' => Identity::class, 'targetAttribute' => 'email'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Password',
        ];
    }
}