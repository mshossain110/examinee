<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sectionable extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    public function sectionable()
    {
        return $this->morphTo();
    }

    public function session()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
