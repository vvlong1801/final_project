<?php

namespace App\Enums\Traits;

trait Helper
{
    public static function getValues(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }

    public static function getNames(): array
    {
        return array_map(fn ($case) => $case->name, self::cases());
    }

    public static function fromValue($value)
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case->name;
            }
        }
        return null;
    }

    public static function fromName(string $name)
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) return $case->value;
        }
    }

    public static function toOptions()
    {
        return \Arr::pluck(self::cases(), 'name', 'name');
    }
}
