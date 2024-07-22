<?php

namespace App\Models;

use App\Models\Exam;
use App\Models\Traits\Fileable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    use SoftDeletes, Fileable, HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'description',
        'requirements',
        'price',
        'discount',
        'thumbnail',
        'start_date',
        'status',
        'features',
        'certified',
        'created_by',
        'updated_by'
    ];
    /*
    |--------------------------------------------------------------------------
    | ACCESORS Variables
    |--------------------------------------------------------------------------
    */
    protected $with = [
        'thumbnail'
    ];

    protected $appends = [
        'permalink',
    ];

    protected $casts = [
        'features' => 'array'
    ];

    /*
    |--------------------------------------------------------------------------
    | Booting
    |--------------------------------------------------------------------------
    */




    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function getRatingAttribute()
    {
        return number_format(DB::table('course_students')->where('course_id', $this->attributes['id'])->average('rating'), 2);
    }

    public function getPermalinkAttribute()
    {
        return route('course.show', ['course' => $this->slug]);
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

        return $query->whereHas('teachers', function ($q) {
            $q->where('user_id', Auth::user()->id);
        });
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

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'sectionable', 'course_id', 'sectionable_id')->wherePivot('sectionable_type', Lesson::class);
    }

    public function publishedLessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('position')->where('status', 1);
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'sectionables', 'course_id', 'sectionable_id')->wherePivot('sectionable_type', Exam::class);
    }

    public function topics()
    {
        return $this->morphToMany(Topic::class, 'topicable');
    }

    public function subjects()
    {
        return $this->morphToMany(Subject::class, 'subjectables');
    }



    public function thumbnail()
    {
        return $this->belongsTo(File::class, 'thumbnail');
    }
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
}
