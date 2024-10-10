<?php

namespace app\forms\password;

use app\components\forms\Form;
use app\enums\IdentityTokenType;
use app\models\IdentityToken;
use Yii;

class ResetPasswordForm extends Form
{
    public ?string $password = null;
    public ?string $confirmPassword = null;

    public function __construct(
        public readonly string $token,
        $config = [],
    ) {
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['token', 'password', 'confirmPassword'], 'required'],
            ['password', 'string', 'min' => Yii::$app->params['identity.minPasswordLength']],
            ['password', 'compare', 'compareAttribute' => 'confirmPassword'],
            [
                'token',
                'exist',
                'targetClass' => IdentityToken::class,
                'targetAttribute' => [
                    'token' => 'token',
                    'token_type' => IdentityTokenType::CONFIRMATION,
                ],
                'message' => 'Password reset token does not exist.',
            ],
        ];
    }
}