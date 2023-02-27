<?php

namespace App\Enums;

enum AccountStatus: int
{
    case not_verified = 1;
    case verified = 2;
    case locked = 3;
}
