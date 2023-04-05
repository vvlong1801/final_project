<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use ReflectionClass;

class EnumController extends Controller
{
    public function getType(string $name)
    {
        $enum = new ReflectionClass("App\Enums\Type" . ucfirst($name));
        $result = \Arr::divide($enum->getConstants());
        return $this->responseOk($result[0]);
    }
}
