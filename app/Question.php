<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'qtype', 'question', 'options', 'answer', 'hint', 'mark', 'nmark', 'explanation', 'defficulty' 
    ];

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
