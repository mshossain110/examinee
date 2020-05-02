<?php

namespace App;

use App\Result;
use App\Pivots\StudentCasting;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes;
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

    protected $appends = [
        'full_name'
    ];

    public function getFullNameAttribute()
    {
        return "$this->firstname $this->lastname";
    }

    public function getAvatarAttribute($value)
    {
        if (!is_array($value)) {
            $value = json_decode($value);
        }

        if (empty($value) && empty($value->avatar)) {
            $value = new \STDClass();
            $value->avatar = $this->get_gravatar($this->email, 200);
        }

        return $value;
    }

    protected function get_gravatar($email, $s = 40, $d = 'mp', $r = 'g', $img = false, $atts = array())
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val) {
                $url .= ' ' . $key . '="' . $val . '"';
            }
            $url .= ' />';
        }
        return $url;
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'examinee');
    }

    public function instructCourses()
    {
        return $this->belongsToMany(Course::class, 'course_teachers');
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'course_students')->using(StudentCasting::class)->withPivot(['rating', 'progress', 'created_at', 'updated_at' ]);
    }

    public function enrolledLessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_student')->using(StudentCasting::class)->withPivot(['status', 'created_at', 'updated_at' ]);
    }
}
