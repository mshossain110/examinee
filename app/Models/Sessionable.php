<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sessionable extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    public function sessionable()
    {
        return $this->morphTo();
    }

    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }
}
