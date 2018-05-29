<?php

namespace App;

use App\User;
use App\Result;
use App\Subject;
use App\Question;
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
    	return $this->belongsToMany( Subject::class, 'exam_subject', 'eid', 'sid' );
    }
    public function questions() {
        return $this->belongsToMany( Question::class, 'exam_question', 'eid', 'qid' );
    }
    public function topics() {
        return $this->belongsToMany( Topic::class, 'exam_question', 'eid', 'tid' );
    }

    public function examResults()
    {
        return $this->hasMany(Result::class, 'eid', 'id');
    }

}
