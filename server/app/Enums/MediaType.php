<?php

namespace App\Enums;

use App\Enums\Traits\Helper;

enum MediaType: int
{
    use Helper;
    case test = 0;
    case image = 1;
    case icon = 2;
    case gif = 3;
    case video = 4;
    case music = 5;
}
