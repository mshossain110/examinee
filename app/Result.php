<?php

namespace App;

<<<<<<< HEAD
use App\Exam;
use App\User;
=======
>>>>>>> 9737d081d3c1b29f212f5586f72242614d1d33cf
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
<<<<<<< HEAD
	protected $fillable = ['sid', 'eid','answer'];


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


    public static function calculateMark($id)
    {
    	$count = 0;
    	$result = Result::findOrFail($id);
    	foreach ($result->answer as $resultKey => $resultValue) {
    		$question = Question::where('id', $resultKey)->first();
    		if (!empty($question)) {
    			foreach ($question->answer as $key => $value) {
    				if ($resultValue == $value) {
    					$count = $count + $question->mark;
    				}
    			}
    		}
    	}
    	return $count;
    }
=======
    //
>>>>>>> 9737d081d3c1b29f212f5586f72242614d1d33cf
}
