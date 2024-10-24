<?php

namespace app\modules\linker\services;

use app\modules\linker\forms\CreateShortUrlForm;
use app\modules\linker\models\ShortUrl;
use app\modules\linker\models\ShortUrlView;
use app\modules\linker\repositories\ShortUrlRepository;

readonly class ShortUrlService
{
    public function __construct(private ShortUrlRepository $shortUrlRepository) {}

    public function create(CreateShortUrlForm $model): ShortUrl
    {
        $model->validateOrPanic();

        return ShortUrl::create($model->url);
    }

    public function getEntityById(string $id): ShortUrl
    {
        return $this->shortUrlRepository->findOneById($id);
    }

    public function go(string $shortUrl): ShortUrl
    {
        $entity = $this->shortUrlRepository->findOneByShortUrl($shortUrl);
        /** On HighLoad use Queue */
        ShortUrlView::create($entity);
        return $entity;
    }
}