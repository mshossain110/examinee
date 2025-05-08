<?php

namespace App\Domain\Common\Enums;

use App\Domain\Common\Enums\Traits\EnumToArray;

enum StatusesEnum: string
{
    use EnumToArray;

    case DISABLED = 'disabled';
    case ENABLED = 'enabled';

    public static function localizedList(): array
    {
        $result = [];

        foreach (self::values() as $value) {
            $result[$value] = __('statuses.'.$value);
        }

        return $result;
    }
}
