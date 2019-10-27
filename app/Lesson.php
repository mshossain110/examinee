<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Topicable;
use Auth;

class Lesson extends Model
{
    use Topicable;
    
    protected $fillable = [
        'title', 
        'slug', 
        'thumbnail', 
        'short_text', 
        'full_text', 
        'position', 
        'type', 
        'object', 
        'status', 
        'course_id', 
        'created_by', 
        'updated_by'
    ];
    
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id')->withTrashed();
    }

    public function students()
    {
        return $this->belongsToMany('App\User', 'lesson_student')->withTimestamps();
    }
}
