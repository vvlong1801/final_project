<?php

namespace App\Enums;

enum PlanStatus: int
{
    case on_going = 1;
    case done = 2;
    case pending = 3;
    case not_stated = 4;
}
