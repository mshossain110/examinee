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
        'created_by',
        'updated_by'
    ];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopePublished($query) {
        return $query->where('status', 1);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function course()
    {
        return $this->belongsToMany( Course::class, 'sessionables', 'sessionable_id', 'course_id' )->wherePivot('sessionable_type', Lesson::class);
    }

    public function students()
    {
        return $this->belongsToMany('App\User', 'lesson_student')->withTimestamps();
    }

    public function sessionable()
    {
        return $this->morphOne(Sessionable::class, 'sessionable');
    }

    public function sessions()
    {
        return $this->morphToMany(Session::class, 'sessionable');
    }
}
