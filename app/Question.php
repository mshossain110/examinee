<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exam;
use App\Subject;
use App\Topic;

class Question extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','qtype', 'question', 'options', 'answer', 'hint', 'mark', 'nmark', 'explanation', 'defficulty' 
    ];
    public function topics() {
        return $this->belongsToMany( Topic::class, 'exam_question', 'qid', 'tid' );
    }

    public function exams() {
        return $this->belongsToMany( Exam::class, 'exam_question', 'qid', 'eid' );
    }

    public function setAnswerAttribute( $value ) {
    	$this->attributes['answer'] = json_encode( $value );
    }

    public function getAnswerAttribute( $value ) {
    	return json_decode( $value );
    }

    public function setOptionsAttribute( $value ) {
    	$this->attributes['options'] = json_encode( $value );
    }

    public function getOptionsAttribute( $value ) {
    	return json_decode( $value );
    }
}
