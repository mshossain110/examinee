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

    public function question() {
    	return $this->belongsToMany( Question::class, 'exams_questions', 'qid', 'tid' );
    }

    public function exam() {
    	return $this->belongsToMany( Exam::class, 'exams_questions', 'eid', 'tid' );
    }
}
