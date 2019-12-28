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
        'title', 'description', 'course_id'
    ];

    public function sessions()
    {
        return $this->hasMany(Sessionable::class, 'session_id')->orderBy('order', 'asc');   
    }


    public function lessons()
    {
        return $this->morphedByMany(Lesson::class, 'sessionable')->orderBy('order', 'asc');
    }

    public function exams()
    {
        return $this->morphedByMany(Exam::class, 'sessionable')->orderBy('order', 'asc');
    }
}
