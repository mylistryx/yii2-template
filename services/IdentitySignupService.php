<?php

namespace app\services;

use app\components\traits\IdentityStatusChecker;
use app\components\traits\SystemMailer;
use app\enums\IdentityStatus;
use app\enums\IdentityTokenType;
use app\forms\SignupForm;
use app\models\Identity;
use app\models\IdentityToken;
use app\repositories\IdentityRepository;
use Throwable;
use Yii;
use yii\db\Exception;

readonly class IdentitySignupService
{
    use IdentityStatusChecker;
    use SystemMailer;

    public function __construct(private IdentityRepository $identityRepository) {}

    /**
     * @throws Exception
     * @throws Throwable
     */
    public function requestSignup(SignupForm $model): void
    {
        $model->validateOrPanic();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $identity = Identity::create($model->email, $model->password);

            if (!Yii::$app->params['identity.needsEmailConfirmation']) {
                $identity->status = IdentityStatus::ACTIVE;
                $identity->saveOrPanic();
                $transaction->commit();
                return;
            }

            $confirmationToken = IdentityToken::create($identity, IdentityTokenType::CONFIRMATION);
            $this->sendSystemMail($identity->email, 'Confirmation token', 'confirmationToken', [
                'confirmationToken' => $confirmationToken,
                'identity' => $identity,
            ]);
            $transaction->commit();
        } catch (Throwable $exception) {
            $transaction->rollBack();
            throw $exception;
        }
    }

    /**
     * @throws Throwable
     */
    public function complete(string $token): void
    {
        $identity = $this->identityRepository->findByConfirmationToken($token);
        $this->checkIdentityStatus($identity, IdentityStatus::INACTIVE);
        $identity->status = IdentityStatus::ACTIVE;
        $identity->saveOrPanic();
        IdentityToken::clean($identity,IdentityTokenType::CONFIRMATION);
    }
}