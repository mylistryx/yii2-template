<?php

namespace app\components\exceptions;

use DomainException;
use Throwable;

class IdentityStatusException extends DomainException
{
    public function __construct($message = 'Invalid identity status', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}