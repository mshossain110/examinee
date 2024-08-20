<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Result;
use App\Pivots\StudentCasting;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $firstname
 * @property string $lastname
 * @property Carbon $email_verified_at
 * @property string $password
 * @property Carbon $last_loged_in
 * @property STDClass $avatar
 * @property string $ip
 * @property string $fullName
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property ?Carbon $deleted_at
 * @property Collection<Role> $roles
 * @property Collection<Result> $results
 * @property Collection<Course> $instructCourses
 * @property Collection<Course> $enrolledCourses
 * @property Collection<Lesson> $enrolledLessons
 */

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes, HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname', 'lastname', 'name', 'email', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be append for arrays.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'full_name'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime:Y-m-d',
            'password' => 'hashed',
            'created_at' => 'datetime:Y-m-d',
            'updated_at' => 'datetime:Y-m-d',
            'deleted_at' => 'datetime:Y-m-d h:i:s'
        ];
    }

    /** --------------------Attributes--------------------------- */
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

    /** --------------------Relations--------------------------- */

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
        return $this->belongsToMany(Course::class, 'course_students')->using(StudentCasting::class)->withPivot(['rating', 'progress', 'created_at', 'updated_at']);
    }

    public function enrolledLessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_student')->using(StudentCasting::class)->withPivot(['status', 'created_at', 'updated_at']);
    }

    /** --------------------Methods--------------------------- */

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

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(Role::SUPERADMIN);
    }

    public function isAdmin(): bool
    {
        return $this->hasAnyRole(Role::SUPERADMIN, Role::ADMIN);
    }
}
