<?php

namespace App;

use Auth;
use App\File;
use App\Traits\Fileable;
use App\Traits\Topicable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use Topicable, Fileable, SoftDeletes;
    
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
    | ACCESORS Variables
    |--------------------------------------------------------------------------
    */
    // protected $casts = [
    //     'object' => 'array'
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['object', 'full_text'];

    public static $types = [
        'text' => 1,
        'video'   => 2,
        'audio' => 3,
        'pdf' => 4
    ];

    public static $status = [
        'free' => 1,
        'subscriber' => 2,
        'paid' => 3,
    ];
    
     /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */


    public function getTypeAttribute($value)
    {
        $key = array_search($value, self::$types);
       
        if ($key) {
            return ucfirst($key);
        }
    }

    public function setTypeAttribute($value)
    {
        $value = strtolower($value);
        $key = array_search($value, self::$types);

       if ($key) {
            $this->attributes['type'] = $value;
       } else {
            $this->attributes['type'] = self::$types[$value];
       }
    }

    public function getStatusAttribute($value)
    {
        $key = array_search($value, self::$status);
       
        if ($key) {
            return ucfirst($key);
        }
    }

    public function setStatusAttribute($value)
    {
        $value = strtolower($value);
        $key = array_search($value, self::$status);

       if ($key) {
            $this->attributes['status'] = $value;
       } else {
            $this->attributes['status'] = self::$status[$value];
       }
    }

    public function getObjectAttribute($value)
    {
        return $this->files->where('id', $value)->first();
    }

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
        return $this->belongsToMany( User::class, 'lesson_student')->withTimestamps();
    }

    public function sessionable()
    {
        return $this->morphOne(Sessionable::class, 'sessionable');
    }

    public function sessions()
    {
        return $this->morphToMany(Session::class, 'sessionable');
    }

    public function objectFile()
    {
        return $this->belongsTo(File::class, 'object');
    }

    /*
    |--------------------------------------------------------------------------
    | OVERWRITE FUNCTIONS
    |--------------------------------------------------------------------------
    */
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
