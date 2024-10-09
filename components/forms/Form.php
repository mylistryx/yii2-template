<?php

namespace app\components\forms;

use app\components\exceptions\ValidationException;
use yii\base\Model;

abstract class Form extends Model
{
    public function validateOrPanic(): true
    {
        if (!$this->validate()) {
            throw new ValidationException($this);
        }

        return true;
    }
}