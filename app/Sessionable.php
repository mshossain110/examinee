<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sessionable extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded=[];


    public function sessionablae()
    {
        return $this->morphTo();
    }
    
}
