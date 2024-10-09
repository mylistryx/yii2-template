<?php

namespace app\components\exceptions;

use DomainException;

class EntityNotFoundException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Entity not found');
    }
}