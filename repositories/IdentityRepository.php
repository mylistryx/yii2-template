<?php

namespace app\repositories;

use app\components\exceptions\EntityNotFoundException;
use app\enums\IdentityTokenType;
use app\models\Identity;

readonly class IdentityRepository
{
    public function __construct(private IdentityTokenRepository $identityTokenRepository) {}

    public function findByEmail($email): Identity
    {
        if (!$entity = Identity::findOne(['email' => $email])) {
            throw new EntityNotFoundException();
        }

        return $entity;
    }

    public function findById($id): Identity
    {
        if (!$entity = Identity::findOne($id)) {
            throw new EntityNotFoundException();
        }

        return $entity;
    }

    public function findByAccessToken(string $token): Identity
    {
        return $this->identityTokenRepository->findByToken($token, IdentityTokenType::ACCESS)->identity;
    }

    public function findByPasswordResetToken(string $token): Identity
    {
        return $this->identityTokenRepository->findByToken($token, IdentityTokenType::PASSWORD_RESET)->identity;
    }

    public function findByConfirmationToken(string $token): Identity
    {
        return $this->identityTokenRepository->findByToken($token, IdentityTokenType::CONFIRMATION)->identity;
    }

}