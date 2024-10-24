<?php

namespace app\modules\linker\repositories;

use app\components\exceptions\EntityNotFoundException;
use app\modules\linker\models\ShortUrl;


class ShortUrlRepository
{
    public function findOneById(int $id): ShortUrl
    {
        if (!$entity = ShortUrl::findOne(['id' => $id])) {
            throw new EntityNotFoundException();
        }

        return $entity;
    }

    public function findOneByShortUrl(string $shortUrl): ShortUrl
    {
        if (!$entity = ShortUrl::findOne(['short_url' => $shortUrl])) {
            throw new EntityNotFoundException();
        }

        return $entity;
    }

    public function save(ShortUrl $entity): void
    {
        $entity->saveOrPanic();
    }
}