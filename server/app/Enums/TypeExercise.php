<?php

namespace App\Enums;

use App\Enums\Traits\Helper;

enum TypeExercise: int
{
    use Helper;

    case counter = 0;
    case timer = 1;
    case runner = 2;
}
