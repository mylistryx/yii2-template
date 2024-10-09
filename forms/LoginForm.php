<?php

namespace app\forms;

use app\components\forms\Form;
use app\models\Identity;
use app\repositories\IdentityRepository;

/**
 * @property-read Identity $identity
 */
class LoginForm extends Form
{
    public function __construct(private readonly IdentityRepository $repository, $config = [])
    {
        parent::__construct($config);
    }

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
            if (!$this->identity->validatePassword($this->$attribute)) {
                $this->addError($attribute, 'Incorrect password.');
            }
        }
    }

    public function getIdentity(): Identity
    {
        return $this->repository->findByEmail($this->email);
    }
}