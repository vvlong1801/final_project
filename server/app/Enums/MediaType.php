<?php

namespace App\Enums;

enum MediaType: int
{
    case test = 0;
    case image = 1;
    case icon = 2;
    case gif = 3;
    case video = 4;
    case music = 5;
}
