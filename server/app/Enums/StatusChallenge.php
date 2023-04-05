<?php

namespace App\Enums;

use App\Enums\Traits\Helper;

enum StatusChallenge: int
{
    use Helper;

    case init = 0;
    case comming = 1;
    case running = 2;
    case pending = 3;
    case finish = 4;
}
