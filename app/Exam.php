<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Subject;

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
}
