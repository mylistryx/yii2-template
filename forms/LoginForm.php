<?php

namespace app\forms;

use app\components\forms\Form;
use app\models\Identity;
use app\repositories\IdentityRepository;
use Yii;
use yii\base\InvalidConfigException;

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

    /**
     * @throws InvalidConfigException
     */
    public function getIdentity(): ?Identity
    {
        $repository = Yii::createObject(IdentityRepository::class);
        return $repository->findByEmail($this->email);
    }
}