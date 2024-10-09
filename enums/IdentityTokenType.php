<?php

namespace app\enums;

use app\components\traits\EnumToArray;

enum IdentityTokenType: int
{
    use EnumToArray;

    case CONFIRMATION = 1;
    case PASSWORD_RESET = 2;
    case CHANGE_PASSWORD = 3;
    case ACCESS = 100;
}