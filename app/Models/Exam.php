<?php

namespace App\Models;

use App\Models\User;
use App\Models\Course;
use App\Models\Result;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $status
 * @property int $duration
 * @property int $price
 * @property int $pass_mark
 * @property array $meta
 * @property int $number_of_questions
 * @property bool $random_questions
 * @property bool $certification
 * @property bool $difficulty
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property Collection<Course> $courses
 * @property Collection<Exam> $exams
 * @property User $examiner
 */

class Exam extends Model
{
    use SoftDeletes, HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'examiner',
        'price',
        'status',
        'duration',
        'pass_mark',
        'meta',
        'number_of_questions',
        'random_questions',
        'certification',
        'difficulty',
    ];

    protected $casts = [
        'meta' => 'array',
    ];


    public function subjects()
    {
        return $this->morphToMany(Subject::class, 'subjectables');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'sectionables', 'sectionable_id', 'course_id')->wherePivot('sectionable_type', Exam::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function topics()
    {
        return $this->morphToMany(Topic::class, 'topicable');
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'exam_id', 'id');
    }

    public function examiner()
    {
        return $this->belongsTo(User::class, 'examiner');
    }

    public static function calculateTotalMark($marks)
    {
        $count = 0;
        foreach ($marks as $mark) {
            $count = $count + $mark->mark;
        }
        return $count;
    }

    public function sectionable()
    {
        return $this->morphOne(Sectionable::class, 'sectionable');
    }
}
