<?php

namespace app\modules\linker\services;

use app\modules\linker\forms\CreateShortUrlForm;
use app\modules\linker\models\ShortUrl;
use app\modules\linker\repositories\LinkerRepository;

readonly class LinkerService
{
    public function __construct(private LinkerRepository $linkerRepository) {}

    public function create(CreateShortUrlForm $model): ShortUrl
    {
        $model->validateOrPanic();

        $linkerModel = ShortUrl::create($model->url);
    }

    public function view() {}
}