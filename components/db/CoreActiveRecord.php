<?php

namespace app\components\db;

use app\components\exceptions\ValidationException;
use yii\db\ActiveRecord;

abstract class CoreActiveRecord extends ActiveRecord
{
    public function saveOrPanic(): bool
    {
        if (!$this->validate()) {
            throw new ValidationException($this);
        }

        $this->save(false);

        return true;
    }
}