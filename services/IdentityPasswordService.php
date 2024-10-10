<?php

namespace app\services;

use app\components\traits\IdentityStatusChecker;
use app\components\traits\SystemMailer;
use app\enums\IdentityStatus;
use app\enums\IdentityTokenType;
use app\forms\password\ChangePasswordForm;
use app\forms\password\RequestPasswordResetForm;
use app\forms\password\ResetPasswordForm;
use app\models\IdentityToken;
use app\repositories\IdentityRepository;
use app\repositories\IdentityTokenRepository;
use Throwable;
use yii\db\StaleObjectException;

class IdentityPasswordService
{
    use IdentityStatusChecker;
    use SystemMailer;

    public function __construct(
        private readonly IdentityRepository $identityRepository,
        private readonly IdentityTokenRepository $identityTokenRepository,
    ) {}

    public function requestPasswordReset(RequestPasswordResetForm $model): void
    {
        $model->validateOrPanic();
        $identity = $this->identityRepository->findByEmail($model->email);
        $this->checkIdentityStatus($identity, IdentityStatus::INACTIVE);
        $passwordResetToken = IdentityToken::create($identity, IdentityTokenType::PASSWORD_RESET);
        $this->sendSystemMail($identity->email, 'Password reset token', 'passwordResetToken', [
            'identity' => $identity,
            'passwordResetToken' => $passwordResetToken,
        ]);
    }

    /**
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function resetPassword(ResetPasswordForm $model): void
    {
        $model->validateOrPanic();
        $token = $this->identityTokenRepository->findByToken($model->token, IdentityTokenType::PASSWORD_RESET);
        $identity = $token->identity;
        $this->checkIdentityStatus($identity, IdentityStatus::ACTIVE);
        $identity->password = $model->password;
        $identity->saveOrPanic();
        $token->delete();
    }

    public function changePassword(ChangePasswordForm $model): void
    {
        $model->validateOrPanic();
        $identity = $model->identity;
        $this->checkIdentityStatus($identity, IdentityStatus::ACTIVE);
        $identity->password = $model->newPassword;
        $identity->saveOrPanic();
    }
}