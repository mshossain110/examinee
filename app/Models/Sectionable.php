<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $section_id
 * @property int $sectionable_id
 * @property string $sectionable_type
 * @property int $order
 * @property int $course_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection<Section> $sectionable
 * @property Section $section
 */

class Sectionable extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];


    public function sectionable()
    {
        return $this->morphTo();
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
