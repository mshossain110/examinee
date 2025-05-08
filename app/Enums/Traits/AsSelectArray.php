<?php

namespace App\Domain\Common\Enums\Traits;

trait AsSelectArray
{
    /**
     * @return array<string,string>
     */
    public static function asSelectArray(): array
    {
        /** @var array<string,string> $values */
        $values = collect(self::cases())
            ->map(function ($enum) {
                return [
                    'name' => self::getDescription($enum),
                    'value' => $enum->value,
                ];
            })->toArray();

        return $values;
    }
}
