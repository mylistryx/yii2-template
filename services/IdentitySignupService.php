<?php

namespace app\services;

use app\components\exceptions\MailerException;
use app\enums\IdentityStatus;
use app\enums\IdentityTokenType;
use app\forms\SignupForm;
use app\models\Identity;
use app\models\IdentityToken;
use app\repositories\IdentityTokenRepository;
use Throwable;
use Yii;
use yii\db\Exception;

readonly class IdentitySignupService
{
    public function __construct(private IdentityTokenRepository $tokenRepository) {}

    /**
     * @throws Exception
     * @throws Throwable
     */
    public function requestSignup(SignupForm $model): bool
    {
        $model->validateOrPanic();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $identity = new Identity();
            $identity->email = $model->email;
            $identity->password = $model->password;
            $identity->saveOrPanic();

            $confirmationToken = new IdentityToken();
            $confirmationToken->identity_id = $identity->id;
            $confirmationToken->type = IdentityTokenType::CONFIRMATION;
            $confirmationToken->saveOrPanic();

            if (!$this->sendConfirmationToken($identity, $confirmationToken)) {
                throw new MailerException();
            }

            $transaction->commit();
        } catch (Throwable $exception) {
            $transaction->rollBack();
            throw $exception;
        }
        return true;
    }

    public function complete(string $token): bool
    {
        $identityToken = $this->tokenRepository->findByToken($token, IdentityTokenType::ACCESS);
        $identity = $identityToken->identity;

        if ($identity->status === IdentityStatus::INACTIVE) {
            $identity->status = IdentityStatus::ACTIVE;
            $identity->saveOrPanic();
            return true;
        }

        return false;
    }

    private function sendConfirmationToken(Identity $identity, IdentityToken $confirmationToken): bool
    {
        return Yii::$app->mailer
            ->compose('confirmationToken', ['confirmationToken' => $confirmationToken, 'identity' => $identity])
            ->setSubject('Confirmation token')
            ->setFrom([Yii::$app->params['system.senderEmail'] => Yii::$app->params['app.companyName']])
            ->setTo($identity->email)
            ->send();
    }
}