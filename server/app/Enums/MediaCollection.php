<?php

namespace App\Enums;

use App\Enums\Traits\Helper;

enum MediaCollection: string
{
    use Helper;

    case test = 'tests';
    case avatar = 'avatars';
    case muscle = 'muscles';
    case equipment = 'equipments';
    case challenge = 'challenges';
    case exercise = 'exercises';
    case plan = 'plans';
    case music = 'musics';
}
