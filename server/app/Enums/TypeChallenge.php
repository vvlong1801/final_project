<?php

namespace App\Enums;

use App\Enums\Traits\Helper;

enum TypeChallenge: int
{
    use Helper;

    case fixed = 1;
    // case compete = 2;
}
