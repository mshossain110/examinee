<?php

namespace App;

use App\User;
use App\Course;
use App\Result;
use App\Subject;
use App\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use SoftDeletes;
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'examiner',
        'status',
        'duration',
        'pass_mark',
        'meta',
        'number_of_questions',
        'random_questions',
        'certification',
        'difficulty',

    ];

    protected $casts = [
        'meta' => 'array',
    ];


    public function subjects() {
    	return $this->morphToMany( Subject::class, 'subjectables' );
    }

    public function courses() {
        return $this->belongsToMany( Course::class, 'sessionables', 'sessionable_id', 'course_id' )->wherePivot('sessionable_type', Exam::class);
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

    public function sessionable()
    {
        return $this->morphOne(Sessionable::class, 'sessionable');
    }
}
