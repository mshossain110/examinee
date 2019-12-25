<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description',
    ];

    public function sessions()
    {
        return $this->hasMany(Sessionable::class, 'session_id')->orderBy('order', 'desc');   
    }
}
