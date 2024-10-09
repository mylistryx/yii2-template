<?php

namespace app\repositories;

use app\components\exceptions\EntityNotFoundException;
use app\enums\IdentityTokenType;
use app\models\IdentityToken;

readonly class IdentityTokenRepository
{
    public function findByToken(string $token, IdentityTokenType $type): IdentityToken
    {
        if (!$entity = IdentityToken::findOne([
            'token' => $token,
            'type' => $type->value,
        ])) {
            throw new EntityNotFoundException();
        }

        return $entity;
    }
}