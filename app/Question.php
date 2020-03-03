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
        'qtype', 'question', 'options', 'answers', 'hint', 'mark', 'nmark', 'explanation', 'defficulty', 'created_by' 
    ];

    protected $casts = [
        'answers' => 'array',
        'options' => 'array'
    ];
    
    public function topics() {
        return $this->morphToMany( Topic::class, 'topicable' );
    }

    public function exam() {
        return $this->belongsTo( Exam::class );
    }

    public function setAnswerAttribute( $value ) {
    	$this->attributes['answers'] = json_encode( $value );
    }
}
