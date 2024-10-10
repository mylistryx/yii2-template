<?php

namespace app\components\exceptions;

use app\components\db\CoreActiveRecord;
use app\components\forms\Form;
use DomainException;
use yii\helpers\Html;

class ValidationException extends DomainException
{
    public function __construct(
        Form|CoreActiveRecord $model,
    ) {
        parent::__construct(Html::errorSummary($model));
    }
}