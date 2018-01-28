<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exam;
class Subject extends Model
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
    	return $this->belongsToMany( Exam::class, 'exam_subject', 'sid', 'eid' );
    }
}
