<?php

namespace App\Traits;

use App\File;

trait Fileable
{
    public function files()
    {
        return $this->morphToMany(File::class, 'fileable');
    }
}
