<?php

namespace app\components\exceptions;

use app\components\forms\Form;
use DomainException;
use Throwable;

class ValidationException extends DomainException
{
    public function __construct(
        Form $model,
        ?string $message = null,
        $code = 0,
        Throwable $previous = null,
    ) {
        $model->getErrors();
        parent::__construct($message, $code, $previous);
    }
}