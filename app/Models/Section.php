<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $course_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection<Sectionable> $sectionables
 * @property Collection<Lesson> $lessons
 * @property Exam<Lesson> $exams
 */

class Section extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title', 'description', 'course_id'
    ];

    public function sectionables()
    {
        return $this->hasMany(Sectionable::class, 'section_id')->orderBy('order', 'asc');
    }


    public function lessons()
    {
        return $this->morphedByMany(Lesson::class, 'sectionable')->orderBy('order', 'asc')->withPivot(['order']);
    }

    public function exams()
    {
        return $this->morphedByMany(Exam::class, 'sectionable')->orderBy('order', 'asc')->withPivot(['order']);
    }
}
