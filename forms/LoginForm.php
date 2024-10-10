<?php

namespace app\forms;

use app\components\forms\Form;
use app\models\Identity;

/**
 * @property-read Identity $identity
 */
class LoginForm extends Form
{
    public ?string $email = null;
    public ?string $password = null;
    public bool $rememberMe = true;

    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword(string $attribute): void
    {
        if (!$this->hasErrors()) {
            if (!$this->identity?->validatePassword($this->password)) {
                $this->addError($attribute, 'PASSWORD_ERROR');
            }
        }
    }

    public function getIdentity(): ?Identity
    {
        return Identity::findIdentityByEmail($this->email);
    }
}