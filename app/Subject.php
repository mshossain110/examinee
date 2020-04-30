<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exam;
class Subject extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description'
    ];

    /**
     * Get all of the courses that are assigned this tag.
     */
    public function courses()
    {
        return $this->morphedByMany(Course::class, 'subjectables');
    }

    /**
     * Get all of the exams that are assigned this tag.
     */
    public function exams()
    {
        return $this->morphedByMany(Exam::class, 'subjectables');
    }
}
