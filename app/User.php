<?php

namespace App;

use App\Result;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'name', 'email', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullNameAttribute()
    {
        return "$this->firstname $this->lastname";
    }

    public function setAvatarAttribute($value)
    {
        if (empty($value)) {
            return get_gravatar($this->emial);
        }

        return $value;
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'examinee');
    }

    public function instructCourses()
    {
        return $this->belongsToMany(Course::class, 'course_teachers');
    }

    public function enrollCourses()
    {
        return $this->belongsToMany(Course::class, 'course_students');
    }
}
