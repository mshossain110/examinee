<?php

namespace App;

use App\Exam;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
	protected $fillable = ['sid', 'eid','answer','obtain'];


	public function resultExam()
	{
		return $this->belongsTo(Exam::class, 'eid');
	}

	public function resultStudent()
	{
		return $this->belongsTo(User::class, 'sid');
	}



    public function setAnswerAttribute( $value ) {
    	$this->attributes['answer'] = json_encode( $value );
    }

    public function getAnswerAttribute( $value ) {
    	return json_decode( $value );
    }


    public static function calculateMark($answer)
    {
    	$count = 0;
        if (!empty($answer)) {
            foreach ($answer as $resultKey => $resultValue) {
                $question = Question::where('id', $resultKey)->first();
                if (!empty($question)) {
                    foreach ($question->answer as $key => $value) {
                        if ($resultValue == $value) {
                            $count = $count + $question->mark;
                        }
                    }
                }
            }
        }
    	return $count;
    }
}
