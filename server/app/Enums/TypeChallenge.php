<?php

namespace App\Enums;

use App\Enums\Traits\Helper;

enum TypeChallenge: int
{
    use Helper;

    case free = 1;
    case compete = 2;
}
