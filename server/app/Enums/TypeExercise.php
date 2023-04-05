<?php

namespace App\Enums;

use App\Enums\Traits\Helper;

enum TypeExercise: int
{
    use Helper;

    case repitition = 0;
    case timeBased = 1;
    case distanceBased = 2;
}
