<?php

namespace App\Supports;

class Helper
{
    public static function randArray($array)
    {
        return $array[array_rand($array, 1)];
    }
}
