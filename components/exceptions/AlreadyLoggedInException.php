<?php

namespace app\components\exceptions;

use DomainException;

class AlreadyLoggedInException extends DomainException
{
    public function __construct()
    {
        parent::__construct("Already logged in");
    }
}