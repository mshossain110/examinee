<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection<Course> $courses
 * @property Collection<Exam> $exams
 */

class Topic extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title', 'description',
    ];

    /**
     * Get all of the courses that are assigned this tag.
     */
    public function courses()
    {
        return $this->morphedByMany(Course::class, 'topicable');
    }

    /**
     * Get all of the exams that are assigned this tag.
     */
    public function exams()
    {
        return $this->morphedByMany(Exam::class, 'topicable');
    }
}
