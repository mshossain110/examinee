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
        'title', 'description','user_id',
    ];

    public function question() {
    	return $this->belongsToMany( Question::class, 'exam_question', 'tid', 'qid' );
    }

    public function exam() {
    	return $this->belongsToMany( Exam::class, 'exam_question', 'eid', 'tid' );
    }
}
