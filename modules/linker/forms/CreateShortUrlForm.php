<?php

namespace app\modules\linker\forms;

use app\components\forms\Form;

class CreateShortUrlForm extends Form
{
    public ?string $url = null;

    public function rules(): array
    {
        return [
            ['url', 'required'],
            ['url', 'url'],
        ];
    }
}