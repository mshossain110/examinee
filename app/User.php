<?php

namespace App;

use App\Result;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'name', 'email', 'password','role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const ADMIN = 1;
    const TEACHER = 2;
    const STUDENT = 3;

    public function getFullNameAttribute()
    {
        return "$this->firstname $this->lastname";
    }

    public function userResults()
    {
        return $this->hasMany(Result::class, 'sid');
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function isAdmin()
    {
        return $this->role()->where('role_id', self::ADMIN)->first();
    }

    public function isTeacher () 
    {
        return $this->role()->where('role_id', self::TEACHER)->first();
    }

    public function isStudent () 
    {
        return $this->role()->where('role_id', self::STUDENT)->first();
    }

    public function instructs()
    {
        return $this->belongsToMany(Course::class, 'course_teachers');
    }

}
