<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Session extends Model
{
    use HasFactory;
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
