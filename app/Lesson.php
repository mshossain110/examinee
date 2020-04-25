<?php

namespace App;

use Auth;
use App\File;
use App\Traits\Topicable;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Fileable;

class Lesson extends Model
{
    use Topicable, Fileable;
    
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

    protected $casts = [
        'object' => 'array'
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
    public function courses()
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
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function setLessonObject(File $file = null) {
        if ($file && $file->id !== $this->object) {
            $this->object = $file->id;
            $this->save();
        }else {
            $file = File::find($this->object);
        }

        if (!$file) {
            return;
        }

        $this->files()->sync($file);
        
        $file->setPermission('public', false)->setPermission('lesson', true)->save();
    }
}
