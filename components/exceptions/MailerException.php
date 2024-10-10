<?php

namespace app\components\exceptions;

use RuntimeException;
use Throwable;

class MailerException extends RuntimeException
{
    public function __construct($message = 'Mailer exception', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}