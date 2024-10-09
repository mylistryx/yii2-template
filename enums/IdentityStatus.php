<?php

namespace app\enums;

use app\components\traits\EnumToArray;

enum IdentityStatus: int
{
    use EnumToArray;

    case INACTIVE = 0;
    case DELETED = 1;
    case ACTIVE = 100;

    public static function defaultValue(): self
    {
        return self::INACTIVE;
    }
}