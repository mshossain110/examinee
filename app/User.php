<?php

namespace App;

use App\Result;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    const TEACHER = 1;
    const STUDENT = 2;

    public function isTeacher()
    {
        return $this->role_id == User::TEACHER;
    } 

    public function isStudent()
    {
        return $this->role_id == User::STUDENT;
    }

    public static function username($id)
    {
        $name = User::findOrFail($id);
        return $name->name; 
    }

    public static function useremail($id)
    {
        $email = User::findOrFail($id);
        return $email->email;
    }
}
