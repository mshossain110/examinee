<?php

namespace App;

use App\User;
use App\Result;
use App\Subject;
use App\Question;
use App\Course;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description',
    ];

    public function subjects() {
    	return $this->morphToMany( Subject::class, 'subjectable' );
    }

    public function courses() {
    	return $this->belongsToMany( Course::class, 'course_exam', 'exam_id', 'course_id' );
    }

    public function questions() {
        return $this->hasMany( Question::class);
    }
    public function topics() {
        return $this->morphToMany( Topic::class, 'topicable' );
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'exam_id', 'id');
    }

    public function examiner()
    {
        return $this->belongsTo(User::class, 'examiner');
    }

    public static function calculateTotalMark($marks)
    {
        $count = 0;
        foreach ($marks as $mark) {
            $count = $count + $mark->mark;
        }
        return $count;
    }
}
