<?php

namespace App\Enums;

enum Role: int
{
    case member = 1;
    case admin = 100;
    case superAdmin = 101;
}
