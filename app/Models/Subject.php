<?php

namespace App\Models;

use App\Models\Exam;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $parent
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string|null $icon
 * @property string|null $image
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection<Course> $courses
 * @property Collection<Exam> $exams
 */
class Subject extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title', 'slug', 'description', 'icon', 'image'
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }
        return Storage::disk('public')->url($this->image);
    }

    /**
     * Get all of the courses that are assigned this tag.
     */
    public function courses()
    {
        return $this->morphedByMany(Course::class, 'subjectables');
    }

    /**
     * Get all of the exams that are assigned this tag.
     */
    public function exams()
    {
        return $this->morphedByMany(Exam::class, 'subjectables');
    }

    /**
     * Get child subjects.
     */
    public function children()
    {
        return $this->hasMany(Subject::class, 'parent');
    }
}

