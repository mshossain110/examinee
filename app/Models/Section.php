<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'course_id'
    ];

    public function sections()
    {
        return $this->hasMany(Sectionable::class, 'section_id')->orderBy('order', 'asc');
    }


    public function lessons()
    {
        return $this->morphedByMany(Lesson::class, 'sectionable')->orderBy('order', 'asc');
    }

    public function exams()
    {
        return $this->morphedByMany(Exam::class, 'sectionable')->orderBy('order', 'asc');
    }
}
