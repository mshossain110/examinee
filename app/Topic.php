<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Question;
use App\Exam;
class Topic extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description',
    ];

    /**
     * Get all of the courses that are assigned this tag.
     */
    public function courses()
    {
        return $this->morphedByMany(Course::class, 'topicable');
    }

    /**
     * Get all of the exams that are assigned this tag.
     */
    public function exams()
    {
        return $this->morphedByMany(Exam::class, 'topicable');
    }
}
