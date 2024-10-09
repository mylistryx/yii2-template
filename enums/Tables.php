<?php

namespace app\enums;

use app\components\traits\EnumToArray;

enum Tables: string
{
    use EnumToArray;

    case IDENTITY = 'identity';
    case IDENTITY_TOKEN = 'identity_token';
}