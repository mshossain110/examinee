<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Traits\Fileable;

class Course extends Model
{
    use SoftDeletes, Fileable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'thumbnail',
        'start_date',
        'status',
        'certified',
        'created_by',
        'updated_by'
    ];
    
    protected $with = [
        'thumbnail'
    ];

    protected $appends = [
        'permalink',
    ];

    /*
    |--------------------------------------------------------------------------
    | Booting
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | ACCESORS Variables
    |--------------------------------------------------------------------------
    */

     /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function getRatingAttribute()
    {
        return number_format(\DB::table('course_student')->where('course_id', $this->attributes['id'])->average('rating'), 2);
    }

    public function getPermalinkAttribute()
    {
        return route('courses.show', ['slug' => $this->attributes['slug']]);
    }
    /**
     * Set attribute to money format
     * @param $input
     */
    public function setPriceAttribute($input)
    {
        $this->attributes['price'] = $input ? $input : null;
    }
    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeOfTeacher($query)
    {
        if (!Auth::user()->isAdmin()) {
            return $query->whereHas('teachers', function($q) {
                $q->where('user_id', Auth::user()->id);
            });
        }
        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'course_teachers');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_students')->withTimestamps()->withPivot(['rating', 'progress']);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('position');
    }

    public function publishedLessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('position')->where('status', 1);
    }

    

    public function thumbnail() {
        return $this->belongsTo(File::class, 'thumbnail');
    }
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
}
