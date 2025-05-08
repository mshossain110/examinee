<?php

namespace App\Domain\Common\Enums\Traits;

use App\Domain\Common\Enums\Attributes\Description;
use Illuminate\Support\Str;
use ReflectionClassConstant;

trait GetsAttributes
{
    private static function getDescription(self $enum): string
    {
        $ref = new ReflectionClassConstant(self::class, $enum->name);
        $classAttributes = $ref->getAttributes(Description::class);

        if (count($classAttributes) === 0) {
            return Str::headline($enum->value);
        }

        return $classAttributes[0]->newInstance()->description;
    }

    public function description(): string
    {
        return self::getDescription($this);
    }
}
