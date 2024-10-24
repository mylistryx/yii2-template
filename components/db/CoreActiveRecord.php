<?php

namespace app\components\db;

use app\components\exceptions\ValidationException;
use Ramsey\Uuid\Uuid;
use yii\db\ActiveRecord;

abstract class CoreActiveRecord extends ActiveRecord
{
    public function saveOrPanic(): static
    {
        if (!$this->validate()) {
            throw new ValidationException($this);
        }

        $this->save(false);

        return $this;
    }

    public function validateUuid(?string $attribute): void
    {
        if (!$this->hasErrors()) {
            $value = $this->$attribute;
            if ($value === null) {
                $this->addError($attribute, 'Uuid is null');
            }
            if (!Uuid::isValid($value)) {
                $this->addError($attribute, 'Uuid is not valid');
            }
        }
    }
}