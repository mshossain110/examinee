<?php

namespace App\Pivots;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class StudentCasting extends MorphPivot
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
