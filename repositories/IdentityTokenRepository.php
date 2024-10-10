<?php

namespace app\repositories;

use app\components\exceptions\EntityNotFoundException;
use app\enums\IdentityTokenType;
use app\models\IdentityToken;

readonly class IdentityTokenRepository
{
    public function findById(string $id): IdentityToken
    {
        if (!$entity = IdentityToken::findIdentityToken($id)) {
            throw new EntityNotFoundException();
        }

        return $entity;
    }

    public function findByToken(string $token, IdentityTokenType $type): IdentityToken
    {
        if (!$entity = IdentityToken::findIdentityTokenByToken($token, $type)) {
            throw new EntityNotFoundException();
        }

        return $entity;
    }
}