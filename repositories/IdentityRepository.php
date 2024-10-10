<?php

namespace app\repositories;

use app\components\exceptions\EntityNotFoundException;
use app\enums\IdentityTokenType;
use app\models\Identity;
use app\models\IdentityToken;

readonly class IdentityRepository
{
    public function __construct(private IdentityTokenRepository $identityTokenRepository) {}

    public function findByEmail($email): Identity
    {
        if (!$entity = Identity::findIdentityByEmail($email)) {
            throw new EntityNotFoundException();
        }

        return $entity;
    }

    public function findById($id): Identity
    {
        if (!$entity = Identity::findIdentity($id)) {
            throw new EntityNotFoundException();
        }

        return $entity;
    }

    public function findByAccessToken(string $token): Identity
    {
        $identityToken = $this->identityTokenRepository->findByToken($token, IdentityTokenType::ACCESS);
        return $identityToken->identity;
    }

    public function findByPasswordResetToken(string $token): Identity
    {
        $identityToken = $this->identityTokenRepository->findByToken($token, IdentityTokenType::PASSWORD_RESET);
        return $identityToken->identity;
    }

    public function findByConfirmationToken(string $token): Identity
    {
        $identityToken = $this->identityTokenRepository->findByToken($token, IdentityTokenType::CONFIRMATION);
        return $identityToken->identity;
    }

}