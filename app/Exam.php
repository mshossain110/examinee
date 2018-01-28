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

    public function subject() {
    	return $this->belongsToMany( Subject::class, 'exam_subject', 'eid', 'sid' );
    }
}
