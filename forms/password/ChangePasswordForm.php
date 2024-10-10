<?php

namespace app\forms\password;

use app\components\forms\Form;
use app\models\Identity;

class ChangePasswordForm extends Form
{
    public ?string $oldPassword = null;
    public ?string $newPassword = null;
    public ?string $newPasswordConfirm = null;

    public function __construct(public readonly Identity $identity, $config = [])
    {
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['oldPassword', 'newPassword', 'newPasswordConfirm'], 'required'],
            [['oldPassword', 'newPassword', 'newPasswordConfirm'], 'string'],
            ['oldPassword', 'validateOldPassword'],
            ['newPassword','compare', 'compareAttribute' => 'newPasswordConfirm'],
        ];
    }

    public function validateOldPassword(string $attribute): void
    {
        if (!$this->hasErrors()) {
            if (!$this->identity->validatePassword($this->oldPassword)) {
                $this->addError($attribute, 'Old password is incorrect.');
            }
        }
    }
}