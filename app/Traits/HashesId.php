<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

trait HashesId
{
    public function getHashAttribute()
    {
        return trim(base64_encode(str_pad($this->getOriginal('id').'|', 10, 'padding')), '=');
    }

    public function scopeWhereHash(Builder $query, $value)
    {
        $id = $this->decodeHash($value);

        return $query->where('id', $id);
    }

    public function decodeHash($hash)
    {
        if ((int) $hash !== 0) {
            return $hash;
        }

        return (int) explode('|', base64_decode($hash))[0];
    }
}
