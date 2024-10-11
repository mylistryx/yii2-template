<?php

namespace app\enums;

use app\components\traits\EnumToArray;

enum Tables: string
{
    use EnumToArray;

    case IDENTITY = 'identity';
    case IDENTITY_TOKEN = 'identity_token';
    case SHORT_URL = 'short_url';
    case SHORT_URL_VIEW = 'short_url_view';
}