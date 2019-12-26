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


    public function sessionable()
    {
        return $this->morphTo();
    }

    public function session ()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }
}
