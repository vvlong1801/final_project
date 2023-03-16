<?php

namespace App\Enums;

enum MediaCollection: string
{
    case test = 'tests';
    case avatar = 'avatars';
    case muscle = 'muscles';
    case equipment = 'equipments';
    case challenge = 'challenges';
    case exercise = 'exercises';
    case plan = 'plans';
    case music = 'musics';
}
